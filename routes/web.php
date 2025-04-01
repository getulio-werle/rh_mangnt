<?php

use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RhUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // home
    Route::redirect('/', 'home');
    Route::view('/home', 'home')->name('home');
    // profile
    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.update-password');
    Route::post('/user/profile/update-data', [ProfileController::class, 'updateData'])->name('user.update-data');
    // departments
    Route::get('/departments', [DepartmentController::class, 'departments'])->name('departments');
    Route::get('/departments/add-department', [DepartmentController::class, 'addDepartment'])->name('departments.add-department');
    Route::post('/departments/create-department', [DepartmentController::class, 'createDepartment'])->name('departments.create-department');
    Route::get('/departments/edit-department/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit-department');
    Route::post('/departments/alter-department', [DepartmentController::class, 'alterDepartment'])->name('departments.alter-department');
    Route::get('/departments/delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('departments.delete-department');
    Route::get('/departments/delete-department_confirm/{id}', [DepartmentController::class, 'deleteDepartmentConfirm'])->name('departments.delete-department-confirm');
    // rh users
    Route::get('/colaborators/rh', [RhUserController::class, 'rhColaborators'])->name('colaborators.rh');
    Route::get('/colaborators/rh/add-colaborator', [RhUserController::class, 'addRhColaborator'])->name('colaborators.rh.add-colaborator');
    Route::post('/colaborators/rh/create-colaborator', [RhUserController::class, 'createRhColaborator'])->name('colaborators.rh.create-colaborator');
    Route::get('/colaborators/rh/edit-colaborator/{id}', [RhUserController::class, 'editRhColaborator'])->name('colaborators.rh.edit-colaborator');
    Route::post('/colaborators/rh/alter-colaborator', [RhUserController::class, 'alterRhColaborator'])->name('colaborators.rh.alter-colaborator');
    Route::get('/colaborators/rh/delete-colaborator/{id}', [RhUserController::class, 'deleteRhColaborator'])->name('colaborators.rh.delete-colaborator');
    Route::get('/colaborators/rh/delete-colaborator-confirm/{id}', [RhUserController::class, 'deleteRhColaboratorConfirm'])->name('colaborators.rh.delete-colaborator-confirm');
});

Route::middleware('guest')->group(function () {
    Route::get('/confirm-account/{token}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
    Route::post('/confirm-account', [ConfirmAccountController::class, 'confirmAccountSubmit'])->name('confirm-account-submit');
});
