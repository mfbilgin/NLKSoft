<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Nette\Schema\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request): Factory|\Illuminate\Foundation\Application|View|Application
    {

        $query = Product::query();
        $query->where('unitsInStock','>',0);
        $query->orderBy('category_id');
        if($request->has('category_id')){
            $query->where('category_id',$request->get('category_id'));
        }

        if($request->has('min_price') && $request->has('max_price')){
            $query->whereBetween('unitPrice',[$request->get('min_price'),$request->get('max_price')]);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $products = $query->get();

        return view('home', compact('products'));

    }
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

    public function showProductDetailPage($id)
    {
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('home')->with('status','info')->with('message','Ürün bulunamadı.');
        }
        if($product->unitsInStock == 0){
            return redirect()->route('home')->with('status','info')->with('message','Ürün stokta bulunmamaktadır.');
        }
        return view('product.product-detail',compact('product'));
    }

    public function showProductByCategoryIdPage(Request $request)
    {
        $categoryId = $request->get('category_id');
        $products = Product::where('category_id',$categoryId)->get();
        return view('product.product-by-category',compact('products'));
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
            'unitPrice' => ['required', 'numeric', 'min:0','max:100000'],
            'unitsInStock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096']
        ]);
    }


}
