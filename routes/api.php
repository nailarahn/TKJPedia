<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\RoadmapApiController;
use App\Http\Controllers\Api\TargetApiController;
use App\Http\Controllers\Api\ProgressApiController;

Route::prefix('v1')->group(function () {

    // Health Check
    Route::get('/ping', function () {
        return response()->json([
            'success'   => true,
            'message'   => 'Mappy Path API is running 🚀',
            'version'   => '1.0.0',
            'timestamp' => now()->toDateTimeString(),
        ]);
    });

    // Auth (Public)
    Route::prefix('auth')->group(function () {
        Route::post('/login',    [AuthApiController::class, 'login']);
        Route::post('/register', [AuthApiController::class, 'register']);
    });

    // Protected (butuh token)
    Route::middleware('auth:sanctum')->group(function () {

        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthApiController::class, 'logout']);
            Route::get('/me',      [AuthApiController::class, 'me']);
        });

        Route::prefix('dashboard')->group(function () {
            Route::get('/',            [DashboardApiController::class, 'index']);
            Route::get('/stats',       [DashboardApiController::class, 'stats']);
            Route::get('/progress',    [DashboardApiController::class, 'progress']);
            Route::get('/recommended', [DashboardApiController::class, 'recommended']);
        });

        Route::prefix('roadmap')->group(function () {
            Route::get('/',     [RoadmapApiController::class, 'index']);
            Route::get('/{id}', [RoadmapApiController::class, 'show']);
        });

        Route::prefix('targets')->group(function () {
            Route::get('/',        [TargetApiController::class, 'index']);
            Route::post('/',       [TargetApiController::class, 'store']);
            Route::put('/{id}',    [TargetApiController::class, 'update']);
            Route::delete('/{id}', [TargetApiController::class, 'destroy']);
        });

        Route::prefix('progress')->group(function () {
            Route::get('/',        [ProgressApiController::class, 'index']);
            Route::get('/weekly',  [ProgressApiController::class, 'weekly']);
            Route::get('/summary', [ProgressApiController::class, 'summary']);
        });
    });
});