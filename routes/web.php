<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PpksImportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PpksDuplicateController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/ppks', [PpksImportController::class, 'index']);
Route::get('/ppks/import', [PpksImportController::class, 'import']);

Route::get('/ppks/perlu-diperiksa', [
    PpksDuplicateController::class,
    'index'
])->name('ppks.duplicates');

Route::patch(
    '/ppks/{ppks}/duplicate-decision',
    [PpksDuplicateController::class, 'decide']
)->name('ppks.duplicate-decision');

require __DIR__.'/auth.php';
