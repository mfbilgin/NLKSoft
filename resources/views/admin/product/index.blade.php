@php use App\Models\Product; @endphp
@extends('layouts.admin')
@section('title','Products')
@section('admin-content')
    @php($products = Product::orderBy('name','asc')->get())
    <div class="container text-center">

        <a class="btn btn-primary float-end" href="{{route('admin.product.add')}}">
            <i class="bi bi-plus-circle-dotted"></i> Yeni Ekle
        </a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ürün Adı</th>
                <th scope="col">Stok Adedi</th>
                <th scope="col">Adet Fiyatı</th>
                <th scope="col">Açıklama</th>
                <th scope="col">Kategori</th>
                <th scope="col">#</th>
                <th scope="col">#</th>
            </tr>
            </thead>
            <tbody>

            @foreach($products as $product)
                <tr>
                    <td>Ürün resmi</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->unitsInStock}}</td>
                    <td>{{$product->unitPrice}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->category}}</td>
                    <td>
                        <a href="{{route('category.edit', $product->id)}}" type="submit"
                           class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Güncelle
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('category.delete', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash3"></i> Sil
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>

        </table>
        @if(count($products) == 0)
            <div class="alert alert-warning" role="alert">
                Ürün Bulunamadı
            </div>
        @endif
    </div>
@endsection
