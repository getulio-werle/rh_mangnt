<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // home
    Route::redirect('/', 'home');
    Route::view('/home', 'home')->name('home');
    // profile
    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update_password', [ProfileController::class, 'update_password'])->name('user.update_password');
    Route::post('/user/profile/update_data', [ProfileController::class, 'update_data'])->name('user.update_data');
});
