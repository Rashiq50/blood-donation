<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;


Auth::routes();

Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])->name('browse');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/profile',[App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('/profile',[App\Http\Controllers\HomeController::class, 'saveProfile'])->name('profile');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
