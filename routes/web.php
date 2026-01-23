<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'loginForm'])->name('home');
    Route::get('/login', [AuthController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    
    Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    
    Route::prefix('/lapangan')->name('lapangan.')->group(function (){
        Route::get('/', [LapanganController::class, 'index'])->name('index');
        Route::get('/create', [LapanganController::class, 'create'])->name('create');
        Route::get('/{lapangan}/edit', [LapanganController::class, 'edit'])->name('edit');
        Route::get('/{lapangan}', [LapanganController::class, 'show'])->name('show');

        Route::post('/', [LapanganController::class, 'store'])->name('store');
        Route::put('/{lapangan}', [LapanganController::class, 'update'])->name('update');
        Route::delete('/{lapangan}', [LapanganController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/lapangan/{lapangan}')->group(function () {
        Route::name('jadwal.')->group(function () {
            Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('create');
            Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('edit');
            
            Route::post('/jadwal', [JadwalController::class, 'store'])->name('store');
            Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('update');
            Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');

        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');

        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/audits')->name('audits.')->group(function () {
        Route::get('/', [AuditController::class, 'index'])->name('index');
        Route::get('/{audit}', [AuditController::class, 'show'])->name('show');
    });
});