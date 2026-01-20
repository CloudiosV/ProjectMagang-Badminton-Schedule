<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\JadwalController;
use App\Http\Controllers\Api\V1\LapanganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('lapangan/{lapangan}', [LapanganController::class, 'show']);

    Route::post('lapangan/{lapangan}/jadwal', [JadwalController::class, 'store']);
    Route::put('lapangan/{lapangan}/jadwal/{jadwal}', [JadwalController::class, 'update']);
    Route::delete('lapangan/{lapangan}/jadwal/{jadwal}', [JadwalController::class, 'destroy']);
});
