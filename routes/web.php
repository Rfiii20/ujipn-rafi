<?php

use App\Http\Controllers\Admin\AspirasiController;
use App\Http\Controllers\Admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Siswa\DashboardController as DashboardSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // cek apakah dia login atau tidak
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('siswa.dashboard');
        }
    }
    // kalau tidak login
    return redirect('/login');
});

// Routing untuk proses login
Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest')->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routing untuk admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
Route::get('/dashboard', [DashboardAdmin::class, 'index'])->name('dashboard');


    // Routing untuk manajemen siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/siswa/tambah', [SiswaController::class, 'create'])->name('tambah-siswa');
    Route::post('/tambah', [SiswaController::class, 'tambahSiswa'])->name('proses-tambah');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa-edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa-update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name( 'siswa-delete');

    // Routing untuk manajemen Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('/form-kategori', [KategoriController::class, 'create'])->name('form-kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('tambah-kategori');
    Route::get('/kategori/edit/{kategori}', [KategoriController::class, 'edit'])->name('form-edit-kategori');
    Route::put('/kategori', [KategoriController::class, 'update'])->name('edit-kategori');
    Route::get('/kategori/delete/{kategori}', [KategoriController::class, 'delete'])->name('hapus-kategori');

    // Routing untuk manajemen Aspirasi
    Route::get('/aspirasi', [AspirasiController::class, 'index'])->name('aspirasi');
    Route::post('/get-aspirasi', [AspirasiController::class, 'getTanggapanByAspirasi'])->name('get-aspirasi');
    Route::post('/tanggapan', [AspirasiController::class, 'addTanggapan'])->name('tanggapan');
    Route::get('/aspirasi/delete/aspirasi/{aspirasi}', [AspirasiController::class, 'delete'])->name('hapus-aspirasi');
    Route::get('/cek-notifikasi', [AspirasiController::class, 'cekNotif'])->name('cek-notifikasi');


    //Routing Untuk Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/cetak-laporan', [LaporanController::class, 'cetak'])->name('cetak-laporan');
});

// Routing untuk siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [DashboardSiswa::class, 'index'])->name('dashboard');

    // Routing untuk manajemen Aspirasi
    Route::get('/aspirasi', [DashboardSiswa::class, 'tambahAspirasi'])->name('tambah-aspirasi');
    Route::post('/aspirasi', [DashboardSiswa::class, 'simpanAspirasi'])->name('proses-tambah');
    Route::get('/aspirasi/edit/{id}', [DashboardSiswa::class, 'editAspirasi'])->name('edit-aspirasi');
    Route::post('/aspirasi/update/{id}', [DashboardSiswa::class, 'updateAspirasi'])->name('update-aspirasi');
    Route::get('/aspirasi/delete/{id}', [DashboardSiswa::class, 'delete'])->name( 'hapus-aspirasi');
    Route::get('/siswa/cek-notif', [DashboardSiswa::class, 'cekNotifSiswa'])->name('cek-notif');
    Route::get('/get-tanggapan', [DashboardSiswa::class, 'gettanggapan'])->name('get-tanggapan');
});
