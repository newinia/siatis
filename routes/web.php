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
    return view('welcome');
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
    | Case Conference
    |--------------------------------------------------------------------------
    */

    Route::get('/case-conference', function () {
        return view('case-conference');
    })->name('case-conference');

    Route::get('/case-conference-detail', function () {
        return view('case-conference-detail');
    })->name('case-conference-detail');


    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    Route::get('/data', function () {
        return view('data');
    })->name('data');

    Route::get('/data-detail', function () {
        return view('data-detail');
    })->name('data-detail');


    /*
    |--------------------------------------------------------------------------
    | Asesmen Instruktur
    |--------------------------------------------------------------------------
    */

    Route::get('/asesmen-instruktur', function () {
        return view('asesmen-instruktur');
    })->name('asesmen-instruktur');

    Route::get('/asesmen-instruktur-detail', function () {
        return view('asesmen-instruktur-detail');
    })->name('asesmen-instruktur-detail');

    Route::get('/instruktur-lolos', function () {
        return view('instruktur-lolos');
    })->name('instruktur-lolos');

    Route::get('/instruktur-tidak-lolos', function () {
        return view('instruktur-tidak-lolos');
    })->name('instruktur-tidak-lolos');

    Route::get('/instruktur-pending', function () {
        return view('instruktur-pending');
    })->name('instruktur-pending');


    /*
    |--------------------------------------------------------------------------
    | Asesmen Kesehatan
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| Asesmen Kesehatan Lanjutan
|--------------------------------------------------------------------------
*/

    Route::get('/asesmen-kesehatan-lanjutan', function () {
        return view('asesmen-kesehatan-lanjutan');
    })->name('asesmen-kesehatan-lanjutan');

    Route::get('/asesmen-kesehatan-lanjutan-detail', function () {
        return view('asesmen-kesehatan-lanjutan-detail');
    })->name('asesmen-kesehatan-lanjutan-detail');

    Route::get('/kesehatan-lanjutan-lolos', function () {
        return view('kesehatan-lanjutan-lolos');
    })->name('kesehatan-lanjutan-lolos');

    Route::get('/kesehatan-lanjutan-tidak-lolos', function () {
        return view('kesehatan-lanjutan-tidak-lolos');
    })->name('kesehatan-lanjutan-tidak-lolos');

    Route::get('/kesehatan-lanjutan-pending', function () {
        return view('kesehatan-lanjutan-pending');
    })->name('kesehatan-lanjutan-pending');



    /*
    |--------------------------------------------------------------------------
    | Asesmen Kesehatan Awal
    |--------------------------------------------------------------------------
    */

    Route::get('/asesmen-kesehatan-awal', function () {
        return view('asesmen-kesehatan-awal');
    })->name('asesmen-kesehatan-awal');

    Route::get('/asesmen-kesehatan-awal-detail', function () {
        return view('asesmen-kesehatan-awal-detail');
    })->name('asesmen-kesehatan-awal-detail');

    Route::get('/kesehatan-awal-lolos', function () {
        return view('kesehatan-awal-lolos');
    })->name('kesehatan-awal-lolos');

    Route::get('/kesehatan-awal-tidak-lolos', function () {
        return view('kesehatan-awal-tidak-lolos');
    })->name('kesehatan-awal-tidak-lolos');

    Route::get('/kesehatan-awal-pending', function () {
        return view('kesehatan-awal-pending');
    })->name('kesehatan-awal-pending');


    /*
    |--------------------------------------------------------------------------
    | Pemanggilan Peserta
    |--------------------------------------------------------------------------
    */

    Route::get('/pemanggilan-peserta', function () {
        return view('pemanggilan-peserta');
    })->name('pemanggilan-peserta');


    /*
    |--------------------------------------------------------------------------
    | Peserta Aktif
    |--------------------------------------------------------------------------
    */

    Route::get('/peserta-aktif', function () {
        return view('peserta-aktif');
    })->name('peserta-aktif');


    /*
    |--------------------------------------------------------------------------
    | Profile
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
