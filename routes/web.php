<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyRequestNotHasAuth;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('product/detail/{id}', [ProductController::class, 'showProductDetailPage'])->name('product.detail');
Route::get('/products', [ProductController::class, 'showProductByCategoryIdPage'])->name('product.by.category');

Route::middleware(VerifyRequestNotHasAuth::class)->group(function () {
    Route::get('register', [RegisterController::class, 'showRegisterPage'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware(VerifyRequestNotHasAuth::class);
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware(['admin', 'verified'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('admin/dashboard', [ProductController::class, 'showProductListPageForAdmin'])->name('admin.dashboard');
    Route::get('admin/product/list', [ProductController::class, 'showProductListPageForAdmin'])->name('admin.product.list');
    Route::get('admin/product/add', [ProductController::class, 'showProductAddPage'])->name('admin.product.add');
    Route::get('admin/product/update/{id}', [ProductController::class, 'showEditProductPage'])->name('product.edit');
    Route::post('product/create', [ProductController::class, 'addProduct'])->name('product.store');
    Route::delete('product/delete/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
    Route::put('product/update/{id}', [ProductController::class, 'updateProduct'])->name('product.update');

    Route::delete('image/delete/{id}', [ImageController::class, 'deleteImage'])->name('image.delete');

    Route::get('admin/category/list', [CategoryController::class, 'showCategoryListPage'])->name('admin.category.list');
    Route::get('admin/category/add', [CategoryController::class, 'showCategoryAddPage'])->name('admin.category.add');
    Route::post('category/create', [CategoryController::class, 'addCategory'])->name('category.store');
    Route::delete('category/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('category.delete');
    Route::get('admin/category/update/{id}', [CategoryController::class, 'showEditCategoryPage'])->name('category.edit');
    Route::put('category/update/{id}', [CategoryController::class, 'updateCategory'])->name('category.update');

    Route::get('admin/user/list', [UserController::class, 'showUserListPage'])->name('admin.user.list');
    Route::delete('admin/user/delete/{id}', [UserController::class, 'deleteUser'])->name('admin.user.delete');
    Route::put('admin/user/change-role/{id}/{newRole}', [UserController::class, 'changeRole'])->name('user.change-role');

    Route::get('admin/review/waiting-list', [ProductReviewController::class, 'show_waiting_reviews'])->name('admin.review.waiting.list');
    Route::get('admin/review/list', [ProductReviewController::class, 'show_all'])->name('admin.review.list');
    Route::put('admin/review/approve/{id}', [ProductReviewController::class, 'approve'])->name('admin.review.approve');
    Route::delete('admin/review/delete/{id}', [ProductReviewController::class, 'delete'])->name('admin.review.delete');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
    Route::put('/cart/increase', [CartController::class, 'increase_cart_item_quantity'])->name('cart.increase');
    Route::put('cart/decrease', [CartController::class, 'decrease_cart_item_quantity'])->name('cart.decrease');
    Route::delete('cart/delete', [CartController::class, 'clear_cart'])->name('cart.empty');

    Route::delete('review/delete/{id}', [ProductReviewController::class, 'destroy'])->name('review.delete');
    Route::post('review/store', [ProductReviewController::class, 'store'])->name('review.store');

    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('cart/address', [AddressController::class, 'show_select_address_page'])->name('address.select');
    Route::post('address/select', [CartController::class, 'select_address'])->name('checkout.address.add');

    Route::get('address/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('address/store', [AddressController::class, 'store'])->name('address.store');

    Route::get('address/edit/{id}', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('address/update/{id}', [AddressController::class, 'update'])->name('address.update');

    Route::delete('address/delete/{id}', [AddressController::class, 'destroy'])->name('address.destroy');

    Route::post('checkout/callback', [CartController::class, 'callback'])->name('checkout.callback')->withoutMiddleware(VerifyCsrfToken::class);

    Route::get('order/success', [OrderController::class, 'success'])->name('order.success');
    Route::post('order/store', [OrderController::class, 'store'])->name('order.store');

    Route::get('orders', [OrderController::class, 'user_order_list'])->name('order.list');
    Route::get('order/detail/{id}', [OrderController::class, 'order_detail'])->name('order.detail');
});
