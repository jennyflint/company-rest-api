<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanySyncResource;
use App\Services\CompanyService;

class CompanyApiController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService
    ) {}

    public function sync(CompanyRequest $request): CompanySyncResource
    {
        $data = $request->validated();
        $result = $this->companyService->syncCompany($data);

        return new CompanySyncResource($result);
    }
}
