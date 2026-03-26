<?php

namespace App\Observers;

use App\Models\Company;
use App\Services\CompanyVersionService;

class CompanyVersionObserver
{
    public function __construct(
        private CompanyVersionService $versionService
    ) {}

    public function saved(Company $company): void
    {
        $changes = collect($company->getChanges())->except(['created_at', 'updated_at']);

        if ($company->wasRecentlyCreated || $changes->isNotEmpty()) {
            $this->versionService->createVersionRecord($company);
        }
    }
}
