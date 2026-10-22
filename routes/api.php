<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AlatController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PeminjamanController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/alat', [AlatController::class, 'index']);
    Route::get('/alat/{id}', [AlatController::class, 'show']);
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/kategori/{id}', [KategoriController::class, 'show']);

    Route::middleware('role:admin')->group(function () {
        Route::post('/alat', [AlatController::class, 'store']);
        Route::put('/alat/{id}', [AlatController::class, 'update']);
        Route::delete('/alat/{id}', [AlatController::class, 'destroy']);

        Route::post('/kategori', [KategoriController::class, 'store']);
        Route::put('/kategori/{id}', [KategoriController::class, 'update']);
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
    });

    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->middleware('role:peminjam');
    Route::put('/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus'])->middleware('role:admin,petugas');
});