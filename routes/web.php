
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;

use App\Http\Controllers\Peminjam\PengembalianController as PeminjamPengembalianController;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;


// ==========================================
// LOGIN
// ==========================================

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.proses');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==========================================
// ADMIN
// ==========================================

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // Kategori
    Route::get('/admin/kategori', [KategoriController::class, 'index']);
    Route::get('/admin/kategori/create', [KategoriController::class, 'create']);
    Route::post('/admin/kategori', [KategoriController::class, 'store']);
    Route::get('/admin/kategori/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update']);
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy']);

    // Alat
    Route::get('/admin/alat', [AlatController::class, 'index']);
    Route::get('/admin/alat/create', [AlatController::class, 'create']);
    Route::post('/admin/alat', [AlatController::class, 'store']);
    Route::get('/admin/alat/{id}/edit', [AlatController::class, 'edit']);
    Route::put('/admin/alat/{id}', [AlatController::class, 'update']);
    Route::delete('/admin/alat/{id}', [AlatController::class, 'destroy']);

    // User
    Route::get('/admin/user', [UserController::class, 'index']);
    Route::get('/admin/user/create', [UserController::class, 'create']);
    Route::post('/admin/user', [UserController::class, 'store']);
    Route::get('/admin/user/{id}/edit', [UserController::class, 'edit']);
    Route::put('/admin/user/{id}', [UserController::class, 'update']);
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy']);

    // Peminjaman
    Route::get('/admin/peminjaman', [PeminjamanController::class, 'index']);

    Route::delete('/admin/peminjaman/riwayat', [
        PeminjamanController::class,
        'destroyAll'
    ])->name('admin.peminjaman.destroyAll');

    // Pengembalian
    Route::get('/admin/pengembalian', [
        PengembalianController::class,
        'index'
    ]);
});


// ==========================================
// PETUGAS
// ==========================================

Route::middleware(['auth', 'role:petugas'])->group(function () {

    // Dashboard
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    });

    // Peminjaman
    Route::get('/petugas/peminjaman', [
        PeminjamanController::class,
        'index'
    ]);

    Route::get('/petugas/peminjaman/{id}', [
        PeminjamanController::class,
        'show'
    ]);

    Route::put('/petugas/peminjaman/{id}/proses', [
        PeminjamanController::class,
        'proses'
    ]);

    // Pengembalian
    Route::get('/petugas/pengembalian', [
        PetugasPengembalianController::class,
        'index'
    ])->name('petugas.pengembalian.index');

    Route::post('/petugas/pengembalian/{id}/konfirmasi', [
        PetugasPengembalianController::class,
        'konfirmasi'
    ])->name('petugas.pengembalian.konfirmasi');
});


// ==========================================
// PEMINJAM
// ==========================================

Route::middleware(['auth', 'role:peminjam'])->group(function () {

    // Dashboard
    Route::get('/peminjam/dashboard', function () {
        return view('peminjam.dashboard');
    });

    // Peminjaman
    Route::get('/peminjam/peminjaman', [
        PeminjamanController::class,
        'index'
    ]);

    Route::get('/peminjam/peminjaman/create', [
        PeminjamanController::class,
        'create'
    ]);

    Route::post('/peminjam/peminjaman', [
        PeminjamanController::class,
        'store'
    ]);

    // Ajukan Pengembalian
    Route::post('/peminjam/peminjaman/{id}/pengembalian', [
        PeminjamPengembalianController::class,
        'ajukan'
    ])->name('peminjam.pengembalian.ajukan');
});
