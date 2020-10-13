<?php

use App\Http\Controllers\Admin\AdminController;

Route::get('/admin/list', [AdminController::class, 'index']);
