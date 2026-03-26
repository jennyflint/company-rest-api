<?php

namespace App\Services;

use App\Models\Company;

class CompanyVersionService
{
    public function createVersionRecord(Company $company): void
    {
        $nextVersion = ($company->versions()->max('version') ?? 0) + 1;

        $newData = collect($company->getAttributes())
            ->except(['id', 'created_at', 'updated_at'])
            ->toArray();

        $oldData = [];
        if (! $company->wasRecentlyCreated) {
            $oldData = collect($company->getOriginal())
                ->except(['id', 'created_at', 'updated_at'])
                ->toArray();
        }

        $company->versions()->create([
            'version' => $nextVersion,
            'data' => [
                'new' => $newData,
                'old' => $oldData,
            ],
        ]);
    }
}
