<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::factory()->create([
            'name' => 'ТОВ Українська енергетична біржа',
            'edrpou' => '3702781912',
            'address' => '01001, Україна, м. Київ, вул. Хрещатик, 44',
        ]);

        Company::factory()->count(19)->create();
    }
}
