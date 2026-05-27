<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Root — redirect ke login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (login, logout, register, dll) — dari Breeze bawaan
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes — wajib login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard — bisa diakses semua user yang sudah login
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | User Management — hanya yang punya permission: create_user
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:create_user')->group(function () {
        Route::get('/users',                   [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create',            [UserController::class, 'create'])->name('users.create');
        Route::post('/users',                  [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit',       [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}',          [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',         [UserController::class, 'destroy'])->name('users.destroy');
    });

    /*
    |----------------------------------------------------------------------
    | Barang & Kategori — permission: create_barang
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:create_barang')->group(function () {
        // Barang
        Route::get('/barang',                  [BarangController::class, 'index'])->name('barang.index');
        Route::get('/barang/create',           [BarangController::class, 'create'])->name('barang.create');
        Route::post('/barang',                 [BarangController::class, 'store'])->name('barang.store');
        Route::get('/barang/{barang}',         [BarangController::class, 'show'])->name('barang.show');
        Route::get('/barang/{barang}/edit',    [BarangController::class, 'edit'])->name('barang.edit');
        Route::patch('/barang/{barang}',       [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{barang}',      [BarangController::class, 'destroy'])->name('barang.destroy');

        // Kategori
        Route::get('/kategori',                    [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/create',             [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori',                   [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}/edit',    [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::patch('/kategori/{kategori}',       [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}',      [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });

    /*
    |----------------------------------------------------------------------
    | Transaksi Barang Masuk & Keluar — permission: create_barang_masuk_keluar
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:create_barang_masuk_keluar')->group(function () {
        Route::get('/transaksi',                        [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/create',                 [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi',                       [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/transaksi/{transaksi}',            [TransaksiController::class, 'show'])->name('transaksi.show');

        // Edit / Update / Delete — split per tipe (masuk vs keluar)
        Route::get('/transaksi/masuk/{masuk}/edit',     [TransaksiController::class, 'editMasuk'])->name('transaksi.editMasuk');
        Route::patch('/transaksi/masuk/{masuk}',        [TransaksiController::class, 'updateMasuk'])->name('transaksi.updateMasuk');
        Route::delete('/transaksi/masuk/{masuk}',       [TransaksiController::class, 'destroyMasuk'])->name('transaksi.destroyMasuk');

        Route::get('/transaksi/keluar/{keluar}/edit',   [TransaksiController::class, 'editKeluar'])->name('transaksi.editKeluar');
        Route::patch('/transaksi/keluar/{keluar}',      [TransaksiController::class, 'updateKeluar'])->name('transaksi.updateKeluar');
        Route::delete('/transaksi/keluar/{keluar}',     [TransaksiController::class, 'destroyKeluar'])->name('transaksi.destroyKeluar');
    });

    /*
    |----------------------------------------------------------------------
    | Kendaraan — permission: create_vehicle
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:create_vehicle')->group(function () {
        Route::get('/kendaraan',                   [KendaraanController::class, 'index'])->name('kendaraan.index');
        Route::get('/kendaraan/create',            [KendaraanController::class, 'create'])->name('kendaraan.create');
        Route::post('/kendaraan',                  [KendaraanController::class, 'store'])->name('kendaraan.store');
        Route::get('/kendaraan/{kendaraan}',       [KendaraanController::class, 'show'])->name('kendaraan.show');
        Route::get('/kendaraan/{kendaraan}/edit',  [KendaraanController::class, 'edit'])->name('kendaraan.edit');
        Route::patch('/kendaraan/{kendaraan}',     [KendaraanController::class, 'update'])->name('kendaraan.update');
        Route::delete('/kendaraan/{kendaraan}',    [KendaraanController::class, 'destroy'])->name('kendaraan.destroy');
    });

    /*
    |----------------------------------------------------------------------
    | Stock Report — permission: stock_report
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:stock_report')->group(function () {
        Route::get('/stock/report',         [StockReportController::class, 'index'])->name('stock.report');
        Route::get('/stock/report/export',  [StockReportController::class, 'export'])->name('stock.report.export');
    });

    /*
    |----------------------------------------------------------------------
    | Laporan — permission: laporan
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:laporan')->group(function () {
        Route::get('/laporan',              [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf',   [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
    });
});
