<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PpksController;
use App\Http\Controllers\PpksImportController;
use App\Http\Controllers\PpksDuplicateController;
use App\Http\Controllers\PpksFileController;
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
    | IMPORT DATA
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

    // Halaman utama
    Route::get(
        '/ppks/normal/asesmen-instruktur',
        [PpksController::class, 'asesmenInstruktur']
    )->name('ppks.normal.instruktur');


    // Data lulus
    Route::get(
        '/ppks/normal/asesmen-instruktur/lulus',
        [PpksController::class, 'asesmenInstrukturLulus']
    )->name('ppks.normal.asesmen-instruktur.lulus');


    // Data pending
    Route::get(
        '/ppks/normal/asesmen-instruktur/pending',
        [PpksController::class, 'asesmenInstrukturPending']
    )->name('ppks.normal.asesmen-instruktur.pending');


    // Data tidak lulus
    Route::get(
        '/ppks/normal/asesmen-instruktur/tidak-lulus',
        [PpksController::class, 'asesmenInstrukturTidakLulus']
    )->name('ppks.normal.asesmen-instruktur.tidak-lulus');


    // Detail data instruktur
    Route::get(
        '/ppks/normal/asesmen-instruktur/{ppks}/detail',
        [PpksController::class, 'asesmenInstrukturDataDetail']
    )->name('ppks.normal.asesmen-instruktur.data-detail');


    // Form asesmen instruktur
    Route::get(
        '/ppks/normal/asesmen-instruktur/{ppks}',
        [PpksController::class, 'asesmenInstrukturDetail']
    )->name('ppks.normal.asesmen-instruktur.detail');


    // Simpan hasil asesmen instruktur
    Route::post(
        '/ppks/normal/asesmen-instruktur/{ppks}',
        [PpksController::class, 'simpanAsesmenInstruktur']
    )->name('ppks.normal.asesmen-instruktur.simpan');


    /*
    |--------------------------------------------------------------------------
    | ASESMEN KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */

    // ================================================================
    // HALAMAN UTAMA - BELUM ASESMEN
    // ================================================================

    Route::get(
        '/ppks/normal/asesmen-kesehatan',
        [PpksController::class, 'asesmenKesehatan']
    )->name('ppks.normal.kesehatan');


    // ================================================================
    // DATA LULUS KESEHATAN
    // ================================================================

    Route::get(
        '/ppks/normal/asesmen-kesehatan/lulus',
        [PpksController::class, 'asesmenKesehatanLulus']
    )->name('ppks.normal.asesmen-kesehatan.lulus');


    // ================================================================
    // DATA PENDING KESEHATAN
    // ================================================================

    Route::get(
        '/ppks/normal/asesmen-kesehatan/pending',
        [PpksController::class, 'asesmenKesehatanPending']
    )->name('ppks.normal.asesmen-kesehatan.pending');


    // ================================================================
    // DATA TIDAK LULUS KESEHATAN
    // ================================================================

    Route::get(
        '/ppks/normal/asesmen-kesehatan/tidak-lulus',
        [PpksController::class, 'asesmenKesehatanTidakLulus']
    )->name('ppks.normal.asesmen-kesehatan.tidak-lulus');


    // ================================================================
    // DETAIL FORM ASESMEN KESEHATAN AWAL
    // ================================================================

    Route::get(
        '/ppks/normal/asesmen-kesehatan/{ppks}/awal',
        [PpksController::class, 'asesmenKesehatanAwalDetail']
    )->name('ppks.normal.asesmen-kesehatan.awal');


    // ================================================================
    // SIMPAN ASESMEN KESEHATAN
    // ================================================================

    Route::post(
        '/ppks/normal/asesmen-kesehatan/{ppks}/awal',
        [PpksController::class, 'simpanAsesmenKesehatanAwal']
    )->name('ppks.normal.asesmen-kesehatan.awal.simpan');


    // ================================================================
    // DETAIL HASIL LULUS
    // ================================================================

    Route::get(
        '/ppks/normal/asesmen-kesehatan/{ppks}/lolos',
        [PpksController::class, 'asesmenKesehatanAwalLolos']
    )->name('ppks.normal.asesmen-kesehatan.lolos');


    // ================================================================
    // DETAIL HASIL PENDING
    // ================================================================

    Route::get(
        '/ppks/normal/asesmen-kesehatan/{ppks}/pending',
        [PpksController::class, 'asesmenKesehatanAwalPending']
    )->name('ppks.normal.asesmen-kesehatan.pending');


    // ================================================================
    // DETAIL HASIL TIDAK LULUS
    // ================================================================

    Route::get(
        '/ppks/normal/asesmen-kesehatan/{ppks}/tidak-lolos',
        [PpksController::class, 'asesmenKesehatanAwalTidakLolos']
    )->name('ppks.normal.asesmen-kesehatan.tidak-lolos');

    Route::get(
    '/ppks/normal/asesmen-kesehatan/{ppks}/lanjutan',
    [PpksController::class, 'asesmenKesehatanLanjutanDetail']
    )->name('ppks.normal.asesmen-kesehatan.lanjutan-detail');

    /*
|--------------------------------------------------------------------------
| CASE CONFERENCE
|--------------------------------------------------------------------------
*/

// ================================================================
// CASE CONFERENCE - BELUM DILAKUKAN
// Lulus Asesmen Kesehatan Awal
// tetapi belum melakukan Case Conference
// ================================================================

Route::get(
    '/ppks/normal/case-conference/belum',
    [PpksController::class, 'caseConferenceBelum']
)->name('ppks.normal.case-conference.belum');


// ================================================================
// CASE CONFERENCE - SUDAH DILAKUKAN
// Sudah melakukan Case Conference:
// - Pending
// - Diterima
// - Tidak Diterima
// ================================================================

Route::get(
    '/ppks/normal/case-conference/sudah',
    [PpksController::class, 'caseConferenceSudah']
)->name('ppks.normal.case-conference.sudah');

Route::get(
    '/ppks/normal/case-conference',
    [PpksController::class, 'caseConference']
)->name('ppks.normal.case-conference');

// ================================================================
// DETAIL CASE CONFERENCE
// ================================================================

Route::get(
    '/ppks/normal/case-conference/{ppks}',
    [PpksController::class, 'caseConferenceDetail']
)->name('ppks.normal.case-conference.detail');


// ================================================================
// SIMPAN CASE CONFERENCE
// ================================================================

Route::post(
    '/ppks/normal/case-conference/{ppks}',
    [PpksController::class, 'updateCaseConference']
)->name('ppks.normal.case-conference.update');
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
    | DETAIL DATA NORMAL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/normal/{ppks}',
        [PpksController::class, 'normalDetail']
    )->name('ppks.normal.detail');


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


    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/perlu-diperiksa/riwayat',
        [PpksDuplicateController::class, 'history']
    )->name('ppks.duplicate-history');


    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN KEPUTUSAN PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

    Route::patch(
        '/ppks/perlu-diperiksa/riwayat/{history}/restore',
        [PpksDuplicateController::class, 'restore']
    )->name('ppks.duplicate-restore');


    /*
    |--------------------------------------------------------------------------
    | GOOGLE DRIVE FILE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/ppks/file/{fileId}',
        [PpksFileController::class, 'show']
    )->name('ppks.file');

});
