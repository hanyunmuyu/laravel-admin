<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::group(['middleware' => [Admin::class]], function () {
        Route::get('/role/list', [RoleController::class, 'getRoleList']);
        Route::delete('/role/{roleId}', [RoleController::class, 'delete']);
        Route::post('/role/{roleId}', [RoleController::class, 'updateRole']);
        Route::get('/role/detail', [RoleController::class, 'getRoleDetail']);
        Route::post('/role/add', [RoleController::class, 'addRole']);
        Route::get('/list', [AdminController::class, 'index']);
        Route::get('/admin/info', [AdminController::class, 'info']);
    });
});
