<?php

use App\Http\Controllers\Api\CompanyApiController;
use App\Http\Controllers\Api\CompanyVersionApiController;
use Illuminate\Support\Facades\Route;

Route::post('/company', [CompanyApiController::class, 'sync'])
    ->name('api.company.sync');

Route::get('/company/{edrpou}/versions', [CompanyVersionApiController::class, 'index'])
    ->name('api.company.versions')
    ->where('edrpou', '[0-9]{8}');
