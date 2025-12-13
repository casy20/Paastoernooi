<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatcheController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MatcheController::class, 'index'])->name('home');
Route::get('/voetbal', [MatcheController::class, 'voetbal'])->name('voetbal');
Route::get('/lijnbal', [MatcheController::class, 'lijnbal'])->name('lijnbal');

Route::resource('teams', TeamController::class);
Route::resource('matches', MatcheController::class);
Route::resource('schools', SchoolController::class);

Route::view('/informatie', 'informatie')->name('informatie');
Route::view('/contact', 'contact')->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/admin/users', [ProfileController::class,'adminUsers'])->name('admin_Users');
    Route::put('/admin/users/{id}', [ProfileController::class,'adminUsersUpdate'])->name('admin_Users.update');
    Route::delete('/admin/users/{id}', [ProfileController::class, 'adminUsersdestroy'])
    ->name('admin_Users.destroy');


    Route::get('/team_create', [TeamController::class,'create'])->name('team_create');
    Route::get('/create_school', [SchoolController::class,'create'])->name('create_school');
});

require __DIR__.'/auth.php';
