<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PpksImportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    Route::get('/data', function () {
        return view('data.data');
    })->name('data');

    // Import Data
    Route::get('/data/import', function () {
        return view('data.data-import');
    })->name('data-import');

    // Data yang perlu diperiksa
    Route::get('/data/perlu-pemeriksaan', function () {
        return view('data.data-perlu-pemeriksaan');
    })->name('data-pemeriksaan');

    // Data yang sudah tervalidasi
    Route::get('/data/tervalidasi', function () {
        return view('data.data-tervalidasi');
    })->name('data-tervalidasi');

    // Detail Data
    Route::get('/data-detail', function () {
        return view('data.data-detail');
    })->name('data-detail');


    /*
    |--------------------------------------------------------------------------
    | ASESMEN INSTRUKTUR
    |--------------------------------------------------------------------------
    */

    Route::get('/asesmen-instruktur', function () {
        return view('instruktur.asesmen-instruktur');
    })->name('asesmen-instruktur');

    Route::get('/instruktur-belum-asesmen', function () {
        return view('instruktur.instruktur-belum-asesmen');
    })->name('instruktur-belum-asesmen');

    Route::get('/instruktur-lolos', function () {
        return view('instruktur.instruktur-lolos');
    })->name('instruktur-lolos');

    Route::get('/instruktur-pending', function () {
        return view('instruktur.instruktur-pending');
    })->name('instruktur-pending');

    Route::get('/instruktur-tidak-lolos', function () {
        return view('instruktur.instruktur-tidak-lolos');
    })->name('instruktur-tidak-lolos');

    Route::get('/asesmen-instruktur-detail', function () {
        return view('instruktur.asesmen-instruktur-detail');
    })->name('asesmen-instruktur-detail');


    /*
    |--------------------------------------------------------------------------
    | ASESMEN KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */

    Route::get('/asesmen-kesehatan-awal', function () {
        return view('kesehatan-awal.asesmen-kesehatan-awal');
    })->name('asesmen-kesehatan-awal');

    Route::get('/kesehatan-awal-belum-asesmen', function () {
        return view('kesehatan-awal.kesehatan-awal-belum-asesmen');
    })->name('kesehatan-awal-belum-asesmen');

    Route::get('/kesehatan-awal-lolos', function () {
        return view('kesehatan-awal.kesehatan-awal-lolos');
    })->name('kesehatan-awal-lolos');

    Route::get('/kesehatan-awal-pending', function () {
        return view('kesehatan-awal.kesehatan-awal-pending');
    })->name('kesehatan-awal-pending');

    Route::get('/kesehatan-awal-tidak-lolos', function () {
        return view('kesehatan-awal.kesehatan-awal-tidak-lolos');
    })->name('kesehatan-awal-tidak-lolos');

    Route::get('/asesmen-kesehatan-awal-detail', function () {
        return view('kesehatan-awal.asesmen-kesehatan-awal-detail');
    })->name('asesmen-kesehatan-awal-detail');


    /*
    |--------------------------------------------------------------------------
    | CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    Route::get('/case-conference/belum', function () {
        return view('case-conference.case-conference-belum');
    })->name('case-conference-belum');

    Route::get('/case-conference/sudah', function () {
        return view('case-conference.case-conference-sudah');
    })->name('case-conference-sudah');

    Route::get('/case-conference-detail', function () {
        return view('case-conference.case-conference-detail');
    })->name('case-conference-detail');

    Route::get('/case-conference', function () {
        return redirect()->route('case-conference-belum');
    })->name('case-conference');


    /*
    |--------------------------------------------------------------------------
    | ASESMEN KESEHATAN LANJUTAN
    |--------------------------------------------------------------------------
    */

    Route::get('/asesmen-kesehatan-lanjutan', function () {
        return view('kesehatan-lanjutan.asesmen-kesehatan-lanjutan');
    })->name('asesmen-kesehatan-lanjutan');

    Route::get('/kesehatan-lanjutan-belum-asesmen', function () {
        return view('kesehatan-lanjutan.kesehatan-lanjutan-belum-asesmen');
    })->name('kesehatan-lanjutan-belum-asesmen');

    Route::get('/kesehatan-lanjutan-lolos', function () {
        return view('kesehatan-lanjutan.kesehatan-lanjutan-lolos');
    })->name('kesehatan-lanjutan-lolos');

    Route::get('/kesehatan-lanjutan-pending', function () {
        return view('kesehatan-lanjutan.kesehatan-lanjutan-pending');
    })->name('kesehatan-lanjutan-pending');

    Route::get('/kesehatan-lanjutan-tidak-lolos', function () {
        return view('kesehatan-lanjutan.kesehatan-lanjutan-tidak-lolos');
    })->name('kesehatan-lanjutan-tidak-lolos');

    Route::get('/asesmen-kesehatan-lanjutan-detail', function () {
        return view('kesehatan-lanjutan.asesmen-kesehatan-lanjutan-detail');
    })->name('asesmen-kesehatan-lanjutan-detail');


    /*
    |--------------------------------------------------------------------------
    | PEMANGGILAN PESERTA
    |--------------------------------------------------------------------------
    */

    Route::get('/pemanggilan-peserta', function () {
        return view('pemanggilan-peserta');
    })->name('pemanggilan-peserta');


    /*
    |--------------------------------------------------------------------------
    | PESERTA AKTIF
    |--------------------------------------------------------------------------
    */

    Route::get('/peserta-aktif', function () {
        return view('peserta-aktif');
    })->name('peserta-aktif');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| PPKS
|--------------------------------------------------------------------------
*/

Route::get('/ppks', [PpksImportController::class, 'index'])
    ->middleware('auth')
    ->name('ppks');

Route::get('/ppks/import', [PpksImportController::class, 'import'])
    ->middleware('auth')
    ->name('ppks.import');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';