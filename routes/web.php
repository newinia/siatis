<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PpksController;
use App\Http\Controllers\PpksImportController;
use App\Http\Controllers\PpksDuplicateController;
use App\Http\Controllers\SuperAdmin\UserApprovalController;

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/super-admin/users',
        [UserApprovalController::class, 'index']
    )->name('admin.index');

    Route::patch(
        '/super-admin/users/{user}/approve',
        [UserApprovalController::class, 'approve']
    )->name('super-admin.users.approve');

    Route::patch(
        '/super-admin/users/{user}/reject',
        [UserApprovalController::class, 'reject']
    )->name('super-admin.users.reject');

    Route::patch(
        '/super-admin/users/{user}/pending',
        [UserApprovalController::class, 'pending']
    )->name('super-admin.users.pending');

    Route::patch(
        '/super-admin/users/{user}/role',
        [UserApprovalController::class, 'updateRole']
    )->name('super-admin.users.role');

    Route::delete(
        '/super-admin/users/{user}',
        [UserApprovalController::class, 'destroy']
    )->name('super-admin.users.destroy');


    /*
    |--------------------------------------------------------------------------
    | DATA PPKS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks',
        [PpksController::class, 'index']
    )->name('ppks.index');


    /*
    |--------------------------------------------------------------------------
    | IMPORT
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/import',
        [PpksImportController::class, 'index']
    )->name('ppks.import');

    Route::post(
        '/ppks/import/process',
        [PpksImportController::class, 'process']
    )->name('ppks.import.process');

    Route::post(
        '/ppks/import/recheck',
        [PpksImportController::class, 'recheck']
    )->name('ppks.import.recheck');


    /*
    |--------------------------------------------------------------------------
    | DATA NORMAL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/normal',
        [PpksController::class, 'normal']
    )->name('ppks.normal');

    Route::get(
        '/ppks/normal/belum-dimulai',
        [PpksController::class, 'belumDimulai']
    )->name('ppks.normal.belum-dimulai');


    /*
    |--------------------------------------------------------------------------
    | ASESMEN INSTRUKTUR
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/normal/asesmen-instruktur',
        [PpksController::class, 'asesmenInstruktur']
    )->name('ppks.normal.instruktur');


    /*
    |--------------------------------------------------------------------------
    | ASESMEN KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/normal/asesmen-kesehatan',
        [PpksController::class, 'asesmenKesehatan']
    )->name('ppks.normal.kesehatan');


    /*
    |--------------------------------------------------------------------------
    | CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/normal/case-conference',
        [PpksController::class, 'caseConference']
    )->name('ppks.normal.case-conference');


    /*
    |--------------------------------------------------------------------------
    | DATA DITERIMA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/diterima',
        [PpksController::class, 'diterima']
    )->name('ppks.diterima');


    /*
    |--------------------------------------------------------------------------
    | DATA TIDAK DITERIMA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/tidak-diterima',
        [PpksController::class, 'tidakDiterima']
    )->name('ppks.tidak-diterima');


    /*
    |--------------------------------------------------------------------------
    | DATA MANUAL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/normal/record',
        [PpksController::class, 'manual']
    )->name('ppks.manual');

    Route::get(
        '/ppks/normal/tambah',
        [PpksController::class, 'createNormal']
    )->name('ppks.normal.create');

    Route::post(
        '/ppks/normal/tambah',
        [PpksController::class, 'storeNormal']
    )->name('ppks.normal.store');


    /*
    |--------------------------------------------------------------------------
    | EDIT DATA MANUAL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/normal/{ppks}/edit',
        [PpksController::class, 'editNormal']
    )->name('ppks.normal.edit');

    Route::put(
        '/ppks/normal/{ppks}',
        [PpksController::class, 'updateNormal']
    )->name('ppks.normal.update');

    Route::delete(
        '/ppks/normal/{ppks}',
        [PpksController::class, 'destroyNormal']
    )->name('ppks.normal.destroy');


    /*
    |--------------------------------------------------------------------------
    | MULAI ASESMEN
    |--------------------------------------------------------------------------
    */

    Route::patch(
        '/ppks/{ppks}/mulai-asesmen',
        [PpksController::class, 'mulaiAsesmen']
    )->name('ppks.mulai-asesmen');


    /*
    |--------------------------------------------------------------------------
    | HASIL ASESMEN
    |--------------------------------------------------------------------------
    */

    Route::patch(
        '/ppks/{ppks}/asesmen/{tahap}',
        [PpksController::class, 'hasilAsesmen']
    )->name('ppks.hasil-asesmen');


    /*
    |--------------------------------------------------------------------------
    | PILIH DATA PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

    Route::patch(
        '/ppks/{ppks}/pilih',
        [PpksController::class, 'pilih']
    )->name('ppks.pilih');


    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN
    |--------------------------------------------------------------------------
    */

    Route::patch(
        '/ppks/{ppks}/kembalikan',
        [PpksController::class, 'kembalikan']
    )->name('ppks.kembalikan');


    /*
    |--------------------------------------------------------------------------
    | PERLU PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/perlu-diperiksa',
        [PpksDuplicateController::class, 'index']
    )->name('ppks.perlu-diperiksa');

    Route::patch(
        '/ppks/{ppks}/duplicate-decision',
        [PpksDuplicateController::class, 'decide']
    )->name('ppks.duplicate-decision');

});
