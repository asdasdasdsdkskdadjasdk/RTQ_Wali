<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SantriController; // Import controller API kita

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Terapkan middleware 'api.auth' ke seluruh grup
Route::prefix('v1/santri')->middleware('api.auth')->group(function () {
    Route::get('/', [SantriController::class, 'index']);
    Route::get('/{id}', [SantriController::class, 'show']);
    Route::get('/{id}/hafalan', [SantriController::class, 'getHafalan']);
    Route::get('/{id}/kehadiran', [SantriController::class, 'getKehadiran']);
});

