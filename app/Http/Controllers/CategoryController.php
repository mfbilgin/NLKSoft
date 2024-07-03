<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function showCategoryAddPage(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.category.category-add');
    }
    public function showCategoryListPage(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.category.category-list');
    }
}
