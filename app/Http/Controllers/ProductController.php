<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nette\Schema\ValidationException;

class ProductController extends Controller
{
    public function showProductAddPage(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.product.product-add');
    }

    public function showProductListPageForAdmin(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('admin.product.index');
    }

    public function showEditProductPage($id)
    {
        $product = Product::find($id);
        return view('admin.product.product-edit',compact('product'));
    }

    public function addProduct(Request $request)
    {
        try {
            $this->validator($request->all())->validate();
        } catch (ValidationException $e) {
            return redirect()->route('admin.product.add')->withErrors($e->validator->errors())->withInput();
        }
        $product = Product::create($request->all());
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $product->images()->create([
                    'url' => 'images/' . $imageName,
                ]);
            }
        }
        return redirect()->route('admin.product.list')->with('info', 'Ürün başarıyla eklendi.');
    }

    public function updateProduct(Request $request, $id): RedirectResponse
    {
        try {
            $this->validator($request->all())->validate();
        } catch (ValidationException $e) {
            return redirect()->route('admin.product.add')->withErrors($e->validator->errors())->withInput();
        }
        $product = Product::find($id);
        $product->update($request->all());
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $product->images()->create([
                    'url' => 'images/' . $imageName,
                ]);
            }
        }
        return redirect()->route('admin.product.list')->with('info', 'Ürün başarıyla güncellendi.');
    }

    public function deleteProduct($id): RedirectResponse
    {
        $product = Product::find($id);
        foreach ($product->images as $image) {
            unlink(public_path($image->url));
        }
        Product::destroy($id);
        return redirect()->route('admin.product.list')->with('info', 'Ürün başarıyla silindi.');
    }

    protected function validator($data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:2', 'unique:categories'],
            'description' => ['required', 'string', 'min:10'],
            'unitPrice' => ['required', 'numeric', 'min:0'],
            'unitsInStock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096']
        ]);
    }
}
