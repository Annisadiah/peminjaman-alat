<?php

use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Peminjam\KatalogController;
use App\Http\Controllers\Peminjam\RiwayatController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController;
use Illuminate\Support\Facades\Route;

// ================= AUTH =================
Route::get('/', fn () => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
    Route::get('/alat/create', [AlatController::class, 'create'])->name('alat.create');
    Route::post('/alat', [AlatController::class, 'store'])->name('alat.store');
    Route::get('/alat/{alat}/edit', [AlatController::class, 'edit'])->name('alat.edit');
    Route::put('/alat/{alat}', [AlatController::class, 'update'])->name('alat.update');
    Route::delete('/alat/{alat}', [AlatController::class, 'destroy'])->name('alat.destroy');

    Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [AdminPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [AdminPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::put('/peminjaman/{peminjaman}/status', [AdminPeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
    Route::delete('/peminjaman/{peminjaman}', [AdminPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});

// ================= PETUGAS =================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/peminjaman', [PetugasPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/{peminjaman}/setujui', [PetugasPeminjamanController::class, 'setujui'])->name('peminjaman.setujui');

    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('/pengembalian/{peminjaman}', [PengembalianController::class, 'proses'])->name('pengembalian.proses');
});

// ================= PEMINJAM =================
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::post('/peminjaman', [KatalogController::class, 'ajukan'])->name('peminjaman.ajukan');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
});
