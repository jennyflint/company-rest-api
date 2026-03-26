<?php

namespace Tests\Feature;

use App\DTO\SyncCompanyDto;
use App\Enums\CompanyStatusEnum;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyServiceTest extends TestCase
{
    use RefreshDatabase;

    private CompanyService $companyService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyService = new CompanyService;
    }

    public function test_it_creates_a_new_company_when_it_does_not_exist()
    {
        $data = Company::factory()->raw();
        $result = $this->companyService->syncCompany($data);

        $this->assertInstanceOf(SyncCompanyDto::class, $result);

        $this->assertEquals(CompanyStatusEnum::CREATED, $result->status);
        $this->assertInstanceOf(Company::class, $result->company);

        $this->assertDatabaseHas('companies', [
            'edrpou' => $data['edrpou'],
            'name' => $data['name'],
        ]);
        $this->assertDatabaseCount('companies', 1);
    }

    public function test_it_updates_an_existing_company_when_data_is_dirty()
    {
        $existingCompany = Company::factory()->create();

        $newData = Company::factory()->raw([
            'edrpou' => $existingCompany->edrpou,
            'name' => 'New Company Name',
        ]);

        $result = $this->companyService->syncCompany($newData);

        $this->assertEquals(CompanyStatusEnum::UPDATED, $result->status);
        $this->assertEquals('New Company Name', $result->company->name);

        $this->assertDatabaseHas('companies', [
            'edrpou' => $existingCompany->edrpou,
            'name' => 'New Company Name',
        ]);
        $this->assertDatabaseCount('companies', 1);
    }

    public function test_it_returns_duplicate_status_when_data_is_identical()
    {
        $existingCompany = Company::factory()->create();
        $data = $existingCompany->only(['name', 'edrpou', 'address']);
        $result = $this->companyService->syncCompany($data);

        $this->assertEquals(CompanyStatusEnum::DUPLICATE, $result->status);
        $this->assertDatabaseCount('companies', 1);
    }
}
