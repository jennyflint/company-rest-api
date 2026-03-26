<?php

namespace App\Services;

use App\DTO\SyncCompanyDto;
use App\Enums\CompanyStatusEnum;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function syncCompany(array $data): SyncCompanyDto
    {
        return DB::transaction(function () use ($data) {

            $company = Company::firstOrNew([
                'edrpou' => $data['edrpou'],
            ]);

            $company->fill($data);

            if (! $company->exists) {
                $company->save();
                $status = CompanyStatusEnum::CREATED;
            } elseif ($company->isDirty()) {
                $company->save();
                $status = CompanyStatusEnum::UPDATED;
            } else {
                $status = CompanyStatusEnum::DUPLICATE;
            }

            return new SyncCompanyDto($company, $status);
        });
    }
}
