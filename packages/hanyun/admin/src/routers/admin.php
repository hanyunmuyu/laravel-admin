<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::group(['middleware' => [Admin::class]], function () {
        Route::get('/role/list', [RoleController::class, 'getRoleList']);
        Route::delete('/role/{roleId}', [RoleController::class, 'delete']);
        Route::put('/role/{roleId}', [RoleController::class, 'updateRole']);
        Route::get('/role/{roleId}', [RoleController::class, 'getRoleDetail']);
        Route::post('/role/add', [RoleController::class, 'addRole']);
        Route::get('/list', [AdminController::class, 'index']);
        Route::get('/admin/info', [AdminController::class, 'info']);
        Route::get('/admin/permission', [AdminController::class, 'getAdminPermission']);
        Route::get('/admin/list', [AdminController::class, 'getAdminList']);
        Route::delete('/admin/{adminId}', [AdminController::class, 'deleteAdmin']);
        Route::post('/admin/{adminId}', [AdminController::class, 'updateAdmin']);
        Route::get('/permission/list', [PermissionController::class, 'getAllPermission']);

        Route::post('/upload', [UploadController::class, 'upload']);

        Route::get('/product/list', [ProductController::class, 'getProductList']);
        Route::delete('/product/{productId}', [ProductController::class, 'deleteProduct']);
        Route::post('/product', [ProductController::class, 'addProduct']);
        Route::get('/product/{productId}', [ProductController::class, 'getProductDetail']);
        Route::put('/product/{productId}', [ProductController::class, 'updateProduct']);
        Route::get('/product/category/list', [ProductCategoryController::class, 'getCategoryList']);
        Route::delete('/product/category/{categoryId}', [ProductCategoryController::class, 'deleteCategory']);
    });
});
