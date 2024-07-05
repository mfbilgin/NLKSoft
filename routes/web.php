<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[ProductController::class,'index'])->name('home');

Route::get('register', [RegisterController::class, 'showRegisterPage'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('admin/dashboard', [ProductController::class, 'showProductListPageForAdmin'])->name('admin.dashboard')->middleware('admin');

Route::get('admin/product/list', [ProductController::class, 'showProductListPageForAdmin'])->name('admin.product.list')->middleware('admin');
Route::get('admin/product/add', [ProductController::class, 'showProductAddPage'])->name('admin.product.add')->middleware('admin');
Route::get('admin/product/update/{id}',[ProductController::class,'showEditProductPage'])->name('product.edit')->middleware('admin');
Route::post('product/create',[ProductController::class,'addProduct'])->name('product.store')->middleware('admin');
Route::delete('product/delete/{id}',[ProductController::class,'deleteProduct'])->name('product.delete')->middleware('admin');
Route::put('product/update/{id}',[ProductController::class,'updateProduct'])->name('product.update')->middleware('admin');
Route::get('product/detail/{id}',[ProductController::class,'showProductDetailPage'])->name('product.detail');
Route::get('/products',[ProductController::class,'showProductByCategoryIdPage'])->name('product.by.category');

Route::delete('image/delete/{id}',[ImageController::class,'deleteImage'])->name('image.delete')->middleware('admin');

Route::get('admin/category/list', [CategoryController::class, 'showCategoryListPage'])->name('admin.category.list')->middleware('admin');
Route::get('admin/category/add', [CategoryController::class, 'showCategoryAddPage'])->name('admin.category.add')->middleware('admin');
Route::post('category/create',[CategoryController::class,'addCategory'])->name('category.store')->middleware('admin');
Route::delete('category/delete/{id}',[CategoryController::class,'deleteCategory'])->name('category.delete')->middleware('admin');
Route::get('admin/category/update/{id}',[CategoryController::class,'showEditCategoryPage'])->name('category.edit')->middleware('admin');
Route::put('category/update/{id}',[CategoryController::class,'updateCategory'])->name('category.update')->middleware('admin');

Route::get('admin/user/list', [UserController::class, 'showUserListPage'])->name('admin.user.list')->middleware('admin');
Route::delete('admin/user/delete/{id}', [UserController::class, 'deleteUser'])->name('admin.user.delete')->middleware('admin');
Route::put('admin/user/change-role/{id}/{newRole}', [UserController::class, 'changeRole'])->name('user.change-role')->middleware('admin');

