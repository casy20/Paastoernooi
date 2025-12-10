<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatcheController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SchoolController;

Route::get('/management', [ManagementController::class, 'index'])->name('management.index');

Route::post('/manuals', [ManualController::class, 'store'])->name('manuals.store');
Route::get('/manuals', [ManualController::class, 'index'])->name('manuals.index');


Route::get('/', [MatcheController::class, 'index'])->name('home');
Route::get('/voetbal', [MatcheController::class, 'voetbal'])->name('voetbal');
Route::get('/lijnbal', [MatcheController::class, 'lijnbal'])->name('lijnbal');


Route::resource('Team', TeamController::class);
Route::resource('Matche', MatcheController::class);
Route::resource('school', SchoolController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/team_create', [TeamController::class,'index'])->name('team_create');
    Route::get('/create_school', [SchoolController::class,'create'])->name('create_school');
});

require __DIR__.'/auth.php';
