<?php

namespace App\DTO;

use App\Enums\CompanyStatusEnum;
use App\Models\Company;

final readonly class SyncCompanyDto
{
    public function __construct(
        public Company $company,
        public CompanyStatusEnum $status,
    ) {}
}
