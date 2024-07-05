@php use App\Models\Product;

@endphp
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
                    <td class="@if(count($product->images)==0) d-none @endif">
                        <div id="{{$product->id}}Carousel" class="carousel slide" style="width: 225px;">
                            <div class="carousel-inner" id="carousel-inner">
                                @foreach($product->images as $key => $image)
                                    <div class="carousel-item @if($key == 0) active @endif">
                                        <img src="{{asset($image->url)}}" style="width: 100%; height: 250px;object-fit: contain"
                                             alt="{{$product->name}}">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev @if(count($product->images)==1) d-none @endif" type="button" data-bs-target="#{{$product->id}}Carousel"
                                    data-bs-slide="prev">
                                <span class="bi bi-arrow-left-circle-fill text-black fs-2" style="border-radius: 25%"
                                      aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next  @if(count($product->images)==1) d-none @endif" type="button" data-bs-target="#{{$product->id}}Carousel"
                                    data-bs-slide="next">
                                <span class="bi bi-arrow-right-circle-fill text-black fs-2" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->unitsInStock}}</td>
                    <td>{{$product->unitPrice}} ₺</td>
                    <td>{!! $product->description !!}</td>
                    <td>{{$product->category->name}}</td>
                    <td>
                        <a href="{{route('product.edit', $product->id)}}" type="submit"
                           class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Güncelle
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('product.delete', $product->id) }}" method="POST">
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
