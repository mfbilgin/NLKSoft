@extends('layouts.app')
@section('title','Product Detail')
@section('styles')
    <style>
        .container {
            margin-top: 50px
        }

        .product-title {
            font-size: 2rem;
            font-weight: bold;
        }

        .breadcrumb-item:hover {
            text-decoration: underline;
        }

        .breadcrumb-item.active:hover {
            text-decoration: none;
        }

        .mt-6 {
            margin-top: 6rem;
        }

        .go-to-desc:hover {
            text-decoration: underline;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-black text-decoration-none">Ana sayfa</a></li>
                <li class="breadcrumb-item"><a
                            href="{{route('product.by.category',['category_id' => $product->category->id])}}"
                            class="text-black text-decoration-none">{{$product->category->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-6 text-center">
                <div id="{{$product->id}}Carousel" class="carousel slide">
                    <div class="carousel-inner" id="carousel-inner">
                        @foreach($product->images as $key => $image)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <img src="{{asset($image->url)}}"
                                     style="width: 100%; height: 500px;object-fit: contain; border-radius: 2%"
                                     alt="{{$product->name}}" class="card-img-top border border-3">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev @if(count($product->images)==1) d-none @endif"
                            type="button" data-bs-target="#{{$product->id}}Carousel"
                            data-bs-slide="prev">
                                <span class="bi bi-arrow-left-circle-fill text-black fs-2" style="border-radius: 25%"
                                      aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next  @if(count($product->images)==1) d-none @endif"
                            type="button" data-bs-target="#{{$product->id}}Carousel"
                            data-bs-slide="next">
                        <span class="bi bi-arrow-right-circle-fill text-black fs-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-md-6 d-flex flex-column">

                <h1 class="product-title text-center mt-2">{{$product->name}}</h1>

                <div class=" float-start">
                    <div class="card d-inline-block border-warning text-center align-content-center mt-5"
                         style="width: 35%; height: 5rem">
                        <p class="text-warning-emphasis fs-3 fw-bold card-text">{{$product->unitPrice}} ₺</p>
                    </div>
                </div>
                <a href="#description" class="text-muted mt-3 text-decoration-none go-to-desc">Ürün Detayı</a>
                @if($product->unitsInStock < 25)
                    <div class="text-center">
                        <div class="mt-5">
                            <p class="text-danger fs-6 fw-bold card-text">
                                Acele et stoklar tükenmek üzere! {{$product->unitsInStock}} adet kaldı!
                            </p>
                        </div>
                    </div>
                @endif

                <a href="{{route('home')}}"
                   class="btn btn-warning text-danger-emphasis w-100 mt-auto bi bi-cart-plus-fill">
                    Sepete Ekle</a>
            </div>
        </div>

        <div class="text-start mt-6 w-50 container" id="description">
            <p class="list-unstyled">{!! $product->description !!}</p>
        </div>

        <div class="container">
            <p>
                DEĞERLENDİRMELER BURAYA GELECEK
            </p>
        </div>
    </div>
@endsection
