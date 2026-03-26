<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;

class CompanyApiController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService
    ) {}

    public function sync(CompanyRequest $request)
    {
        $data = $request->validated();
        $response = $this->companyService->syncCompany($data);

        return response()->json([
            'status' => $response->status->value,
            'company' => $response->company,
        ]);
    }
}
