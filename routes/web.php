<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('register', [RegisterController::class, 'showRegisterPage'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('admin/dashboard', [ProductController::class, 'showProductListPage'])->name('admin.dashboard')->middleware('admin');

Route::get('admin/product/list', [ProductController::class, 'showProductListPage'])->name('admin.product.list')->middleware('admin');
Route::get('admin/product/add', [ProductController::class, 'showProductAddPage'])->name('admin.product.add')->middleware('admin');

Route::get('admin/category/list', [CategoryController::class, 'showCategoryListPage'])->name('admin.category.list')->middleware('admin');
Route::get('admin/category/add', [CategoryController::class, 'showCategoryAddPage'])->name('admin.category.add')->middleware('admin');

Route::get('admin/user/list', [UserController::class, 'showUserListPage'])->name('admin.user.list')->middleware('admin');
Route::delete('admin/user/delete/{id}', [UserController::class, 'deleteUser'])->name('admin.user.delete')->middleware('admin');
Route::put('admin/user/change-role/{id}/{newRole}', [UserController::class, 'changeRole'])->name('admin.user.change-role')->middleware('admin');
