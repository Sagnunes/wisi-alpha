<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserStatusController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class)->only(['index', 'destroy']);

    Route::resource('role-permission', RolePermissionController::class)->only(['show', 'update'])->parameters(['role-permission' => 'role']);
    Route::resource('user-role', USerRoleController::class)->only(['show', 'update'])->parameters(['user-role' => 'user']);
    Route::resource('user-status', UserStatusController::class)->only(['update'])->parameters(['user-status' => 'user']);
});
