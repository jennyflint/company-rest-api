<?php

namespace App\Services;

use App\DTO\SyncCompanyDto;
use App\Enums\CompanyStatusEnum;
use App\Models\Company;

class CompanyService
{
    public function syncCompany(array $data): SyncCompanyDto
    {

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

        $company->loadMax('versions', 'version');

        return new SyncCompanyDto($company, $status);

    }
}
