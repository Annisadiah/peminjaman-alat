<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AlatController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use App\Http\Controllers\Api\DetailPinjamController;
use App\Http\Controllers\Api\LogAktivitasController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('role.admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::apiResource('kategori', KategoriController::class);
        Route::apiResource('log-aktivitas', LogAktivitasController::class);
    });

    Route::middleware('role.petugas')->group(function () {
        Route::apiResource('alat', AlatController::class);
        Route::apiResource('peminjaman', PeminjamanController::class);
        Route::apiResource('pengembalian', PengembalianController::class);
        Route::apiResource('detail-pinjam', DetailPinjamController::class);
    });

    Route::middleware('role.peminjam')->group(function () {
        Route::get('/alat', [AlatController::class, 'index']);
        Route::get('/alat/{alat}', [AlatController::class, 'show']);

        Route::get('/peminjaman', [PeminjamanController::class, 'index']);
        Route::post('/peminjaman', [PeminjamanController::class, 'store']);
        Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show']);
    });
});
