<?php

use App\Http\Controllers\Api\CompanyApiController;
use Illuminate\Support\Facades\Route;

Route::post('/company', [CompanyApiController::class, 'sync'])
    ->name('api.company');
