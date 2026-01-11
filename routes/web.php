<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatcheController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SchoolController;
use Illuminate\Routing\RouteUri;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [MatcheController::class, 'index'])->name('home');
Route::get('/voetbal', [MatcheController::class, 'voetbal'])->name('voetbal');
Route::get('/lijnbal', [MatcheController::class, 'lijnbal'])->name('lijnbal');
Route::get('/wedstrijden', [MatcheController::class, 'list'])->name('matches.list');
Route::get('/scores', [MatcheController::class, 'scores'])->name('matches.scores');

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

    Route::get('/team_create', [TeamController::class,'create'])->name('team_create');
    Route::get('/create_school', [SchoolController::class,'create'])->name('create_school');
    
    // Admin routes - alleen voor admins (check gebeurt in controllers)
    Route::post('/match_generen', [MatcheController::class, 'generate'])->name('match.generate');
    Route::post('/match_generen/clear', [MatcheController::class, 'clear'])->name('match.clear');
    Route::get('/match_generen/handmatig', [MatcheController::class, 'manualNextRound'])->name('match.manualNextRound');
    Route::post('/match_generen/handmatig', [MatcheController::class, 'storeManualMatch'])->name('match.storeManualMatch');
    Route::post('/match_generen/next-round', [MatcheController::class, 'generateNextRound'])->name('match.generateNextRound');
    Route::post('/match_generen/clear-next-round', [MatcheController::class, 'clearNextRound'])->name('match.clearNextRound');
    Route::put('/matches/{id}/score', [MatcheController::class, 'updateScore'])->name('matches.updateScore');
Route::delete('/matches/{id}', [MatcheController::class, 'destroy'])->name('matches.destroy');
    
    Route::get('/admin/users', [ProfileController::class,'adminUsers'])->name('admin_Users');
    Route::put('/admin/users/{id}', [ProfileController::class,'adminUsersUpdate'])->name('admin_Users.update');
    Route::delete('/admin/users/{id}', [ProfileController::class, 'adminUsersdestroy'])
    ->name('admin_Users.destroy');
   
    Route::get('/admin/school', [SchoolController::class,'index'])->name('admin_Schools');
    Route::delete('/admin/school/{id}', [SchoolController::class, 'destroy'])
    ->name('admin_Schools.destroy');    
    route::put('/admin/schools/{id}', [SchoolController::class,'Update'])->name('admin_Schools.update');

    // Admin teams
    Route::get('/admin/teams', [TeamController::class,'adminIndex'])->name('admin_Teams');
    Route::put('/admin/teams/{id}', [TeamController::class,'adminUpdate'])->name('admin_Teams.update');
    Route::delete('/admin/teams/{id}', [TeamController::class,'adminDestroy'])->name('admin_Teams.destroy');

});

require __DIR__.'/auth.php';
