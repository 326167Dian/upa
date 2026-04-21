<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FotoKegiatanController;
use App\Http\Controllers\JenisJurnalController;
use App\Http\Controllers\JurnalKasController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/register', [AuthController::class, 'createRegistration'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegistration'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->middleware('feature:dashboard.view')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/operators', [OperatorController::class, 'index'])->middleware('feature:operators.view')->name('operators.index');
    Route::get('/operators/create', [OperatorController::class, 'create'])->middleware('feature:operators.create')->name('operators.create');
    Route::post('/operators', [OperatorController::class, 'store'])->middleware('feature:operators.create')->name('operators.store');
    Route::get('/operators/{operator}', [OperatorController::class, 'show'])->middleware('feature:operators.view')->name('operators.show');
    Route::get('/operators/{operator}/edit', [OperatorController::class, 'edit'])->middleware('feature:operators.edit')->name('operators.edit');
    Route::match(['put', 'patch'], '/operators/{operator}', [OperatorController::class, 'update'])->middleware('feature:operators.edit')->name('operators.update');
    Route::delete('/operators/{operator}', [OperatorController::class, 'destroy'])->middleware('feature:operators.delete')->name('operators.destroy');

    Route::get('/kegiatan', [KegiatanController::class, 'index'])->middleware('feature:kegiatan.view')->name('kegiatan.index');
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->middleware('feature:kegiatan.create')->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->middleware('feature:kegiatan.create')->name('kegiatan.store');
    Route::get('/kegiatan/{kegiatan}/edit', [KegiatanController::class, 'edit'])->middleware('feature:kegiatan.edit')->name('kegiatan.edit');
    Route::match(['put', 'patch'], '/kegiatan/{kegiatan}', [KegiatanController::class, 'update'])->middleware('feature:kegiatan.edit')->name('kegiatan.update');
    Route::delete('/kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->middleware('feature:kegiatan.delete')->name('kegiatan.destroy');

    Route::get('/kehadiran', [KehadiranController::class, 'index'])->middleware('feature:kehadiran.view')->name('kehadiran.index');
    Route::get('/kehadiran/create', [KehadiranController::class, 'create'])->middleware('feature:kehadiran.create')->name('kehadiran.create');
    Route::post('/kehadiran', [KehadiranController::class, 'store'])->middleware('feature:kehadiran.create')->name('kehadiran.store');
    Route::get('/kehadiran/{kehadiran}/edit', [KehadiranController::class, 'edit'])->middleware('feature:kehadiran.edit')->name('kehadiran.edit');
    Route::match(['put', 'patch'], '/kehadiran/{kehadiran}', [KehadiranController::class, 'update'])->middleware('feature:kehadiran.edit')->name('kehadiran.update');
    Route::delete('/kehadiran/{kehadiran}', [KehadiranController::class, 'destroy'])->middleware('feature:kehadiran.delete')->name('kehadiran.destroy');

    Route::get('/pengumuman', [PengumumanController::class, 'index'])->middleware('feature:pengumuman.view')->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->middleware('feature:pengumuman.create')->name('pengumuman.create');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->middleware('feature:pengumuman.create')->name('pengumuman.store');
    Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->middleware('feature:pengumuman.edit')->name('pengumuman.edit');
    Route::match(['put', 'patch'], '/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->middleware('feature:pengumuman.edit')->name('pengumuman.update');
    Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->middleware('feature:pengumuman.delete')->name('pengumuman.destroy');
    Route::post('/pengumuman/upload-image', [PengumumanController::class, 'uploadImage'])->name('pengumuman.upload-image');

    Route::get('/foto-kegiatan', [FotoKegiatanController::class, 'index'])->middleware('feature:foto_kegiatan.view')->name('foto-kegiatan.index');
    Route::get('/foto-kegiatan/{fotoKegiatan}/download', [FotoKegiatanController::class, 'download'])->name('foto-kegiatan.download');
    Route::get('/foto-kegiatan/create', [FotoKegiatanController::class, 'create'])->middleware('feature:foto_kegiatan.create')->name('foto-kegiatan.create');
    Route::post('/foto-kegiatan', [FotoKegiatanController::class, 'store'])->middleware('feature:foto_kegiatan.create')->name('foto-kegiatan.store');
    Route::get('/foto-kegiatan/{fotoKegiatan}/edit', [FotoKegiatanController::class, 'edit'])->middleware('feature:foto_kegiatan.edit')->name('foto-kegiatan.edit');
    Route::match(['put', 'patch'], '/foto-kegiatan/{fotoKegiatan}', [FotoKegiatanController::class, 'update'])->middleware('feature:foto_kegiatan.edit')->name('foto-kegiatan.update');
    Route::delete('/foto-kegiatan/{fotoKegiatan}', [FotoKegiatanController::class, 'destroy'])->middleware('feature:foto_kegiatan.delete')->name('foto-kegiatan.destroy');

    Route::prefix('jurnal-kas')->name('jurnal-kas.')->group(function () {
        Route::get('/', [JurnalKasController::class, 'index'])->middleware('feature:jurnal_kas.view')->name('index');
        Route::get('/laporan/filter', [JurnalKasController::class, 'reportFilter'])->middleware('feature:jurnal_kas.view')->name('report.filter');
        Route::get('/laporan', [JurnalKasController::class, 'report'])->middleware('feature:jurnal_kas.view')->name('report.index');
        Route::get('/rekap/filter', [JurnalKasController::class, 'recapFilter'])->middleware('feature:jurnal_kas.view')->name('recap.filter');
        Route::get('/rekap', [JurnalKasController::class, 'recap'])->middleware('feature:jurnal_kas.view')->name('recap.index');

        Route::get('/pengeluaran/create', [JurnalKasController::class, 'createExpense'])->middleware('feature:jurnal_kas.create')->name('expenses.create');
        Route::post('/pengeluaran', [JurnalKasController::class, 'storeExpense'])->middleware('feature:jurnal_kas.create')->name('expenses.store');
        Route::get('/pemasukan/create', [JurnalKasController::class, 'createIncome'])->middleware('feature:jurnal_kas.create')->name('incomes.create');
        Route::post('/pemasukan', [JurnalKasController::class, 'storeIncome'])->middleware('feature:jurnal_kas.create')->name('incomes.store');

        Route::get('/{jurnal}/edit', [JurnalKasController::class, 'edit'])->middleware('feature:jurnal_kas.edit')->name('edit');
        Route::put('/{jurnal}', [JurnalKasController::class, 'update'])->middleware('feature:jurnal_kas.edit')->name('update');
        Route::delete('/{jurnal}', [JurnalKasController::class, 'destroy'])->middleware('feature:jurnal_kas.delete')->name('destroy');

        Route::prefix('jenis-transaksi')->name('types.')->group(function () {
            Route::get('/', [JenisJurnalController::class, 'index'])->middleware('feature:jurnal_kas.view')->name('index');
            Route::get('/create', [JenisJurnalController::class, 'create'])->middleware('feature:jurnal_kas.create')->name('create');
            Route::post('/', [JenisJurnalController::class, 'store'])->middleware('feature:jurnal_kas.create')->name('store');
            Route::get('/{type}/edit', [JenisJurnalController::class, 'edit'])->middleware('feature:jurnal_kas.edit')->name('edit');
            Route::put('/{type}', [JenisJurnalController::class, 'update'])->middleware('feature:jurnal_kas.edit')->name('update');
            Route::delete('/{type}', [JenisJurnalController::class, 'destroy'])->middleware('feature:jurnal_kas.delete')->name('destroy');
        });
    });
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});
