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
        Route::get('/role/{roleId}', [RoleController::class, 'getRoleDetail']);
        Route::post('/role/add', [RoleController::class, 'addRole']);
        Route::get('/list', [AdminController::class, 'index']);
        Route::get('/admin/info', [AdminController::class, 'info']);
        Route::get('/admin/list', [AdminController::class, 'getAdminList']);
        Route::delete('/admin/{adminId}', [AdminController::class, 'deleteAdmin']);
        Route::post('/admin/{adminId}', [AdminController::class, 'updateAdmin']);
    });
});
