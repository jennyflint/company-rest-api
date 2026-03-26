<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

class CompanyVersionApiController extends Controller
{
    public function index(string $edrpou): CompanyResource
    {
        $company = Company::with([
            'versions' => fn ($q) => $q->orderByDesc('version'),
        ])->withMax('versions', 'version')
            ->where('edrpou', $edrpou)
            ->firstOrFail();

        return new CompanyResource($company);
    }
}
