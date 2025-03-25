<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo 'RH Mangnt';
});

// test
Route::get('/admin', function () {
    $admin = User::with('details', 'department')->find(1);
    dd($admin);
});
