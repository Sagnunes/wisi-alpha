<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('role-permission', RolePermissionController::class)->only(['show', 'store', 'destroy'])->parameters(['role-permission' => 'role']);
    Route::resource('users', UserController::class)->only(['index', 'destroy']);
});
