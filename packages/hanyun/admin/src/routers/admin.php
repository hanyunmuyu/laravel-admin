<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserGlassesController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/category/all', [CategoryController::class, 'getAllCategory']);

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
        Route::get('/product/option/{productId}', [ProductController::class, 'getProductOption']);
        Route::get('/category/list', [CategoryController::class, 'getCategoryList']);
        Route::delete('/category/{categoryId}', [CategoryController::class, 'deleteCategory']);
        Route::get('/category/{categoryId}', [CategoryController::class, 'getCategoryDetail']);
        Route::put('/category/{categoryId}', [CategoryController::class, 'updateCategory']);
        Route::post('/category', [CategoryController::class, 'addCategory']);

        Route::get('/order/list', [OrderController::class, 'getOrderList']);
        Route::delete('/order/{orderNumber}', [OrderController::class, 'deleteOrder']);
        Route::get('/order/detail/{orderId}', [OrderController::class, 'getOrderDetail']);

        Route::get('/user/list', [UserController::class, 'getUserList']);
        Route::delete('/user/{userId}', [UserController::class, 'deleteUser']);

        Route::get('/option/list', [OptionController::class, 'getOptionList']);
        Route::get('/option/{optionId}', [OptionController::class, 'getOptionDetail']);
        Route::put('/option/{optionId}', [OptionController::class, 'updateOption']);
        Route::post('/option', [OptionController::class, 'addOption']);

        Route::get('/option/type/list', [OptionController::class, 'getOptionTypeList']);




        Route::get('/user/glasses/list/{userId}', [UserGlassesController::class, 'getUserGlassesList']);

    });
});
