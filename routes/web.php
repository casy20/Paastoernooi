<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatcheController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MatcheController::class, 'index'])->name('home');
Route::get('/voetbal', [MatcheController::class, 'voetbal'])->name('voetbal');
Route::get('/lijnbal', [MatcheController::class, 'lijnbal'])->name('lijnbal');


Route::resource('paastoernoois', TeamController::class);
Route::resource('Paastournoois', MatcheController::class);
Route::resource('Paastournoois', SchoolController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/team_create', [TeamController::class,'index'])->name('team_create');
});

require __DIR__.'/auth.php';
