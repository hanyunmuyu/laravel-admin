<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::get('/list', [Admin\AdminController::class, 'index']);
    Route::post('/login', [Admin\LoginController::class, 'login']);

});
