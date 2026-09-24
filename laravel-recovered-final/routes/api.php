<?php

use App\Http\Controllers\Api\AlatController;
use App\Http\Controllers\Api\DetailPinjamController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LogAktivitasController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('kategori', KategoriController::class);
Route::apiResource('alat', AlatController::class);
Route::apiResource('peminjaman', PeminjamanController::class);
Route::apiResource('detail-pinjam', DetailPinjamController::class);
Route::apiResource('pengembalian', PengembalianController::class);
Route::apiResource('log-aktivitas', LogAktivitasController::class);
