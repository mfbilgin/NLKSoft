<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Rules\MultipleWords;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nette\Schema\ValidationException;

class CategoryController extends Controller
{
    public function showCategoryAddPage(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.category.category-add');
    }

    public function showCategoryListPage(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.category.index');
    }

    public function showEditCategoryPage($id): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $category = Category::find($id);
        return view('admin.category.category-edit', compact('category'));
    }

    public function addCategory(Request $request): RedirectResponse
    {
        try {
            $this->validator($request->all())->validate();
        } catch (ValidationException $e) {
            return redirect()->route('admin.category.add')->withErrors($e->validator->errors())->withInput();
        }
        Category::create($request->all());
        return redirect()->route('admin.category.list')->with('info', 'Kategori başarıyla eklendi.');
    }

    public static function deleteCategory($id): RedirectResponse
    {
        Category::destroy($id);
        return redirect()->route('admin.category.list')->with('info', 'Kategori başarıyla silindi.');
    }

    public function updateCategory(Request $request, $id): RedirectResponse
    {
        try {
            $this->validator($request->all())->validate();
        } catch (ValidationException $e) {
            return redirect()->route('admin.category.add')->withErrors($e->validator->errors())->withInput();
        }
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('admin.category.list')->with('info', 'Kategori başarıyla güncellendi.');
    }

    protected function validator($data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:4', 'unique:categories'],
        ]);
    }
}

