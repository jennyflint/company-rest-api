<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanySyncApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_sync_creates_company_and_version()
    {
        $data = [
            'name' => 'New Company LLC',
            'edrpou' => '12345678',
            'address' => 'Kyiv, Ukraine',
        ];

        $response = $this->postJson('/api/company', $data);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'created')
            ->assertJsonPath('data.company.name', 'New Company LLC')
            ->assertJsonPath('data.company.edrpou', '12345678')
            ->assertJsonPath('data.company.current_version', 1);

        $this->assertDatabaseHas('companies', ['edrpou' => '12345678']);

        $company = Company::where('edrpou', '12345678')->first();
        $this->assertCount(1, $company->versions);
    }

    public function test_api_sync_updates_data_and_increments_version()
    {
        $company = Company::factory()->create([
            'name' => 'Old Name',
            'edrpou' => '87654321',
            'address' => 'Old Address',
        ]);

        $updateData = [
            'name' => 'Brand New Name',
            'edrpou' => '87654321',
            'address' => 'New York, USA',
        ];

        $response = $this->postJson('/api/company', $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'updated')
            ->assertJsonPath('data.company.current_version', 2);

        $latestVersion = $company->versions()->latest('version')->first();

        $this->assertEquals(2, $latestVersion->version);

        $this->assertEquals('Brand New Name', $latestVersion->data['new']['name']);
        $this->assertEquals('Old Name', $latestVersion->data['old']['name']);
    }

    public function test_can_get_company_versions_history()
    {
        Company::factory()->create(['edrpou' => '55556666']);

        $this->postJson('/api/company', [
            'name' => 'Updated Name',
            'edrpou' => '55556666',
            'address' => 'Lviv',
        ]);

        $response = $this->getJson('/api/company/55556666/versions');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'edrpou',
                    'current_version',
                    'history' => [
                        '*' => [
                            'version_number',
                            'snapshot' => [
                                'new',
                                'old',
                            ],
                            'created_at',
                        ],
                    ],
                ],
            ]);

        $this->assertCount(2, $response->json('data.history'));
        $this->assertEquals('Updated Name', $response->json('data.history.0.snapshot.new.name'));
    }
}
