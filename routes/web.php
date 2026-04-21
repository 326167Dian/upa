<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisJurnalController;
use App\Http\Controllers\JurnalKasController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('operators', OperatorController::class)->except('show');
    Route::resource('kegiatan', KegiatanController::class)->except('show');
    Route::resource('kehadiran', KehadiranController::class)->except('show');
    Route::prefix('jurnal-kas')->name('jurnal-kas.')->group(function () {
        Route::get('/', [JurnalKasController::class, 'index'])->name('index');
        Route::get('/pengeluaran/create', [JurnalKasController::class, 'createExpense'])->name('expenses.create');
        Route::post('/pengeluaran', [JurnalKasController::class, 'storeExpense'])->name('expenses.store');
        Route::get('/pemasukan/create', [JurnalKasController::class, 'createIncome'])->name('incomes.create');
        Route::post('/pemasukan', [JurnalKasController::class, 'storeIncome'])->name('incomes.store');
        Route::get('/laporan/filter', [JurnalKasController::class, 'reportFilter'])->name('report.filter');
        Route::get('/laporan', [JurnalKasController::class, 'report'])->name('report.index');
        Route::get('/rekap/filter', [JurnalKasController::class, 'recapFilter'])->name('recap.filter');
        Route::get('/rekap', [JurnalKasController::class, 'recap'])->name('recap.index');
        Route::get('/{jurnal}/edit', [JurnalKasController::class, 'edit'])->name('edit');
        Route::put('/{jurnal}', [JurnalKasController::class, 'update'])->name('update');
        Route::delete('/{jurnal}', [JurnalKasController::class, 'destroy'])->name('destroy');

        Route::prefix('jenis-transaksi')->name('types.')->group(function () {
            Route::get('/', [JenisJurnalController::class, 'index'])->name('index');
            Route::get('/create', [JenisJurnalController::class, 'create'])->name('create');
            Route::post('/', [JenisJurnalController::class, 'store'])->name('store');
            Route::get('/{type}/edit', [JenisJurnalController::class, 'edit'])->name('edit');
            Route::put('/{type}', [JenisJurnalController::class, 'update'])->name('update');
            Route::delete('/{type}', [JenisJurnalController::class, 'destroy'])->name('destroy');
        });
    });
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});
