<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatcheController;

Route::get('/', [MatcheController::class, 'index'])->name('home');

Route::resource('Paastournoois', MatcheController::class);

Route::get('/informatie', function () {
    return view('informatie');
})->name('informatie');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', function () {
    return view('login');
})->name('login');
