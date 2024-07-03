<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
    public function showEditCategoryPage($id): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $category = Category::find($id);
        return view('admin.category.category-edit', compact('category'));
    }

    public static function addCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);
        Category::create($request->all());
        return redirect()->route('admin.category.list')->with('info', 'Kategori başarıyla eklendi.');
    }

    public static function deleteCategory($id): RedirectResponse
    {
        Category::destroy($id);
        return redirect()->route('admin.category.list')->with('info', 'Kategori başarıyla silindi.');
    }

    public static function updateCategory(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'
        ]);
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('admin.category.list')->with('info', 'Kategori başarıyla güncellendi.');
    }

}

