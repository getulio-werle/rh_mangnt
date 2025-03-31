<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RhUserController;
use App\Models\Department;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // home
    Route::redirect('/', 'home');
    Route::view('/home', 'home')->name('home');
    // profile
    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update_password', [ProfileController::class, 'update_password'])->name('user.update_password');
    Route::post('/user/profile/update_data', [ProfileController::class, 'update_data'])->name('user.update_data');
    // departments
    Route::get('/departments', [DepartmentController::class, 'departments'])->name('departments');
    Route::get('/departments/add_department', [DepartmentController::class, 'add_department'])->name('department.add_department');
    Route::post('/departments/create_department', [DepartmentController::class, 'create_department'])->name('department.create_department');
    Route::get('/departments/edit_department/{id}', [DepartmentController::class, 'edit_department'])->name('department.edit_department');
    Route::post('/departments/alter_department', [DepartmentController::class, 'alter_department'])->name('department.alter_department');
    Route::get('/departments/delete_department/{id}', [DepartmentController::class, 'delete_department'])->name('department.delete_department');
    Route::get('/departments/delete_department_confirm/{id}', [DepartmentController::class, 'delete_department_confirm'])->name('department.delete_department_confirm');
    // rh users
    Route::get('/rh_colaborators', [RhUserController::class, 'index'])->name('rh_colaborators');
    Route::get('/rh_colaborators/add_rh_colaborator', [RhUserController::class, 'add_rh_colaborator'])->name('rh_colaborators.add_rh_colaborator');
    Route::post('/rh_colaborators/create_rh_colaborator', [RhUserController::class, 'create_rh_colaborator'])->name('rh_colaborators.create_rh_colaborator');
});
