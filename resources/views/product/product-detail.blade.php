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

        .go-to-desc:hover {
            text-decoration: underline;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-black text-decoration-none">
                        {{__('titles.titles.home')}}
                    </a>
                </li>
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

                <div class="row">

                    <div class="col-6">
                        <div class="text-center mt-5">
                            <p class="text-success-emphasis fs-3 fw-bold card-text">{{$product->unitPrice}} ₺</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center mt-5">
                            <p class="fs-5 fw-bold card-text">
                                {{$product->get_avg_rating()}} / 5 ({{$product->get_reviews_count()}} {{__('titles.review.review')}})
                            </p>
                            @if($product->get_reviews_count() == 0)
                                @if(auth()->check() &&((auth()->user()->is_bought_product($product) == 1)))
                                    <a href="#rating" class="text-muted" style="font-size: 0.8rem">{{__('messages.product.review_first')}}</a>
                                @else
                                    <span class="text-muted" style="font-size: 0.8rem">
                                        {{__('messages.product.no_review')}}
                                    </span>
                                @endif
                            @else
                                <a href="#rating" class="text-muted" style="font-size: 0.8rem">
                                    {{__('titles.product.show_reviews')}}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="#description" class="text-muted mt-3 text-decoration-none go-to-desc">{{__('titles.product.detail')}}</a>
                @if($product->unitsInStock < 25)
                    <div class="text-center">
                        <div class="mt-5">
                            <p class="text-danger fs-6 fw-bold card-text">
                                Acele et stoklar tükenmek üzere! {{$product->unitsInStock}} adet kaldı!
                            </p>
                        </div>
                    </div>
                @endif

                <form action="{{route('cart.add')}}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <button class="btn btn-success w-100  bi bi-cart-plus-fill" type="submit">
                        {{__('titles.product.add_to_cart')}}
                    </button>
                </form>
            </div>
        </div>

        <div class="text-start mt-5 container" id="description">
            <p class="list-unstyled">{!! $product->description !!}</p>
        </div>
        <div id="rating">
            @if(session('review_status'))
                <div class="w-50 mt-5 text-center mx-auto alert alert-{{session('review_status')}} alert-dismissible">
                    {{session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(auth()->check() && auth()->user()->has_reviewed($product->id) != 1 && ((auth()->user()->is_bought_product($product) == 1)))
                @include('product_reviews.create')
            @endif
            @include('product_reviews.index')
        </div>

    </div>
@endsection
