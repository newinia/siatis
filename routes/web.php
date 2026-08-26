<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PpksImportController;
use App\Http\Controllers\PpksDuplicateController;
use App\Http\Controllers\PpksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// HALAMAN UTAMA
// =========================

Route::get('/', function () {
    return view('welcome');
});

// =========================
// DASHBOARD
// =========================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =========================
// PROFILE
// =========================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// =========================
// PPKS
// =========================

Route::middleware('auth')->group(function () {

    // =========================
    // SEMUA DATA PPKS
    // =========================

    Route::get('/ppks', [PpksController::class, 'index'])
        ->name('ppks.index');


    // =========================
    // DATA NORMAL
    // =========================

    Route::get('/ppks/normal', [PpksController::class, 'normal'])
        ->name('ppks.normal');


    // =========================
    // PILIH DATA
    // Pemeriksaan → Data Normal
    // =========================

    Route::patch(
        '/ppks/{ppks}/pilih',
        [PpksController::class, 'pilih']
    )->name('ppks.pilih');


    // =========================
    // KEMBALIKAN DATA
    // Data Normal → Pemeriksaan
    // =========================

    Route::patch(
        '/ppks/{ppks}/kembalikan',
        [PpksController::class, 'kembalikan']
    )->name('ppks.kembalikan');


    // =========================
    // IMPORT PPKS
    // =========================

    // Halaman Import
    Route::get(
        '/ppks/import',
        [PpksImportController::class, 'index']
    )->name('ppks.import');


    // Import data BARU saja
    Route::post(
        '/ppks/import/process',
        [PpksImportController::class, 'import']
    )->name('ppks.import.process');


    // Cek ulang SELURUH data yang sudah ada
    Route::post(
        '/ppks/import/recheck',
        [PpksImportController::class, 'recheck']
    )->name('ppks.import.recheck');


    // =========================
    // PERLU PEMERIKSAAN
    // =========================

    Route::get(
        '/ppks/perlu-diperiksa',
        [
            PpksDuplicateController::class,
            'index'
        ]
    )->name('ppks.perlu-diperiksa');


    // =========================
    // KEPUTUSAN PEMERIKSAAN
    // =========================

    Route::patch(
        '/ppks/{ppks}/duplicate-decision',
        [PpksDuplicateController::class, 'decide']
    )->name('ppks.duplicate-decision');

});


// =========================
// AUTH
// =========================

require __DIR__.'/auth.php';
