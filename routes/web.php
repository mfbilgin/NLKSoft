<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('register', [RegisterController::class, 'showRegisterPage'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('admin/dashboard', [AdminController::class, 'productList'])->name('admin.dashboard')->middleware('admin');

Route::get('admin/product/list', [AdminController::class, 'productList'])->name('admin.product.list')->middleware('admin');
Route::get('admin/product/add', [AdminController::class, 'productAdd'])->name('admin.product.add')->middleware('admin');

Route::get('admin/category/list', [AdminController::class, 'categoryList'])->name('admin.category.list')->middleware('admin');
Route::get('admin/category/add', [AdminController::class, 'categoryAdd'])->name('admin.category.add')->middleware('admin');

Route::get('admin/user/list', [AdminController::class, 'userList'])->name('admin.user.list')->middleware('admin');
Route::delete('admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete')->middleware('admin');
Route::put('admin/user/change-role/{id}/{newRole}', [AdminController::class, 'changeRole'])->name('admin.user.change-role')->middleware('admin');
