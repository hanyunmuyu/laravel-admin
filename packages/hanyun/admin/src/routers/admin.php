<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [Admin\LoginController::class, 'login']);
    Route::group(['middleware' => ['admin']], function () {
        Route::get('/role/list', [Admin\RoleController::class, 'getRoleList']);
        Route::get('/list', [Admin\AdminController::class, 'index']);
    });
});
