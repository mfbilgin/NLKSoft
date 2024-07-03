<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showProductAddPage(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.product.product-add');
    }
    public function showProductListPage(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.product.product-list');
    }

}
