<?php

use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\TechnicalConclusionController;
use App\Http\Controllers\WarrantyClaimController;
use App\Http\Controllers\WarrantyClaimServiceWorkController;
use App\Http\Controllers\WarrantyClaimSparepartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('warranty_claims')->group(function () {
        Route::get('/search', [WarrantyClaimController::class, 'search']);
        Route::get('/service-centers', [WarrantyClaimController::class, 'getServiceCenters']);
        Route::post('/store', [WarrantyClaimController::class, 'store']);
    });

    Route::prefix('warranty_claim_service_works')->group(function () {
        Route::get('/list', [WarrantyClaimServiceWorkController::class, 'list']);
    });

    Route::prefix('warranty_claim_spareparts')->group(function () {
        Route::get('/list', [WarrantyClaimSparepartController::class, 'list']);
    });

    Route::prefix('technical_conclusions')->group(function () {
        Route::get('/search', [TechnicalConclusionController::class, 'search']);
        Route::post('/store', [TechnicalConclusionController::class, 'store']);
    });

    Route::prefix('directories')->group(function () {
        Route::get('/tab-data', [DirectoryController::class, 'getDirectoryData']);
        Route::get('/folders', [DirectoryController::class, 'getDirectoryFolders']);
    });
});
