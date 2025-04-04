<?php

use App\Http\Controllers\ColaboratorController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/confirm-account/{token}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
    Route::post('/confirm-account', [ConfirmAccountController::class, 'confirmAccountSubmit'])->name('confirm-account-submit');
});

Route::middleware('auth')->group(function () {
    // home
    Route::redirect('/', 'home');
    Route::view('/home', 'home')->name('home');
    // profile
    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.update-password');
    Route::post('/user/profile/update-data', [ProfileController::class, 'updateData'])->name('user.update-data');
    // departments
    Route::get('/departments', [DepartmentController::class, 'getDepartments'])->name('departments');
    Route::get('/departments/add-department', [DepartmentController::class, 'addDepartment'])->name('departments.add-department');
    Route::post('/departments/create-department', [DepartmentController::class, 'createDepartment'])->name('departments.create-department');
    Route::get('/departments/edit-department/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit-department');
    Route::post('/departments/alter-department', [DepartmentController::class, 'alterDepartment'])->name('departments.alter-department');
    Route::get('/departments/delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('departments.delete-department');
    Route::get('/departments/delete-department_confirm/{id}', [DepartmentController::class, 'deleteDepartmentConfirm'])->name('departments.delete-department-confirm');
    // rh colaborators
    Route::get('/colaborators/rh', [ColaboratorController::class, 'getRhColaborators'])->name('colaborators.rh');
    Route::get('/colaborators/rh/add-colaborator', [ColaboratorController::class, 'addRhColaborator'])->name('colaborators.rh.add-colaborator');
    Route::post('/colaborators/rh/create-colaborator', [ColaboratorController::class, 'createRhColaborator'])->name('colaborators.rh.create-colaborator');
    Route::get('/colaborators/rh/edit-colaborator/{id}', [ColaboratorController::class, 'editRhColaborator'])->name('colaborators.rh.edit-colaborator');
    Route::post('/colaborators/rh/alter-colaborator', [ColaboratorController::class, 'alterRhColaborator'])->name('colaborators.rh.alter-colaborator');
    Route::get('/colaborators/rh/delete-colaborator/{id}', [ColaboratorController::class, 'deleteRhColaborator'])->name('colaborators.rh.delete-colaborator');
    Route::get('/colaborators/rh/delete-colaborator-confirm/{id}', [ColaboratorController::class, 'deleteRhColaboratorConfirm'])->name('colaborators.rh.delete-colaborator-confirm');
    Route::get('/colaborators/rh/restore-colaborator/{id}', [ColaboratorController::class, 'restoreRhColaborator'])->name('colaborators.rh.restore-colaborator');
    // general colaborators
    Route::get('/colaborators', [ColaboratorController::class, 'getColaborators'])->name('colaborators');
    Route::get('/colaborators/colaborator-details/{id}', [ColaboratorController::class, 'colaboratorDetails'])->name('colaborators.colaborator-details');
    Route::get('/colaborators/add-colaborator', [ColaboratorController::class, 'addColaborator'])->name('colaborators.add-colaborator');
    Route::post('/colaborators/create-colaborator', [ColaboratorController::class, 'createColaborator'])->name('colaborators.create-colaborator');
    Route::get('/colaborators/edit-colaborator/{id}', [ColaboratorController::class, 'editColaborator'])->name('colaborators.edit-colaborator');
    Route::post('/colaborators/alter-colaborator', [ColaboratorController::class, 'alterColaborator'])->name('colaborators.alter-colaborator');
    Route::get('/colaborators/delete-colaborator/{id}', [ColaboratorController::class, 'deleteColaborator'])->name('colaborators.delete-colaborator');
    Route::get('/colaborators/delete-colaborator-confirm/{id}', [ColaboratorController::class, 'deleteColaboratorConfirm'])->name('colaborators.delete-colaborator-confirm');
    Route::get('/colaborators/restore-colaborator/{id}', [ColaboratorController::class, 'restoreColaborator'])->name('colaborators.restore-colaborator');
    // all colaborators (admin only)
    Route::get('/colaborators/all', [ColaboratorController::class, 'getAllColaborators'])->name('colaborators.all');
});
