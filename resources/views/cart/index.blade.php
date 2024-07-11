@php use App\Models\Cart;use App\Models\CartItem; @endphp
@extends('layouts.app')
@section('styles')
    <style>

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            width: fit-content;
        }

        .quantity-selector button {
            background-color: white;
            border: none;
            padding: 0 10px;
            font-size: 1.5rem;
            color: #ff8800;
            cursor: pointer;
        }

        .quantity-selector input {
            border: none;
            text-align: center;
            width: 40px;
            font-size: 1.2rem;
        }

        .quantity-selector input:focus {
            outline: none;
        }

        /* Fare imlecinin el ikonu şeklinde ayarlanması*/
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection
@section('title','Sepetim')
@section('content')
    @php
        $user_id = auth()->id();
        $cart = Cart::where('user_id',$user_id)->first();
        $cart_items = CartItem::where('cart_id',$cart->id)->get();
        $total_price = $cart->total_price();
    @endphp
    <div class="container mt-md-5 mt-sm-0">
        <div class="row">
            <h3 class="mb-lg-5 mb-md-2">Sepetim ({{count($cart_items)}} Ürün)</h3>
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($cart_items as $cart_item)
                                @php
                                    $product = $cart_item->product;
                                @endphp
                                <li class="list-group-item border-0">
                                    <div class="row">
                                        <div class="col-4">
                                            <div id="{{$product->id}}Carousel"
                                                 class="carousel slide d-inline-block w-100">
                                                <div class="carousel-inner" id="carousel-inner">
                                                    @foreach($product->images as $key => $image)
                                                        <div class="carousel-item @if($key == 0) active @endif">
                                                            <img src="{{asset($image->url)}}"
                                                                 style="width: 100%; height: 200px;object-fit: contain; border-radius: 2%"
                                                                 alt="{{$product->name}}"
                                                                 class="card-img-top border border-3">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button
                                                    class="carousel-control-prev @if(count($product->images)==1) d-none @endif"
                                                    type="button" data-bs-target="#{{$product->id}}Carousel"
                                                    data-bs-slide="prev">
                                                                    <span
                                                                        class="bi bi-arrow-left-circle-fill text-black fs-2"
                                                                        style="border-radius: 25%"
                                                                        aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button
                                                    class="carousel-control-next  @if(count($product->images)==1) d-none @endif"
                                                    type="button" data-bs-target="#{{$product->id}}Carousel"
                                                    data-bs-slide="next">
                                                                                <span
                                                                                    class="bi bi-arrow-right-circle-fill text-black fs-2"
                                                                                    aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>

                                        </div>
                                        <div class="col-8 d-flex flex-column">
                                            <h5 class="card-title cursor-pointer">{{$product->name}}</h5>

                                            <div class="quantity-selector" id="quantity-selector-{{$cart_item->id}}">
                                                <button id="quantity_decrease_btn_{{$cart_item->id}}" type="button"
                                                        onclick="decreaseQuantity('{{$cart_item->id}}')">-
                                                </button>
                                                <input id="quantity_{{$cart_item->id}}" type="text"
                                                       value="{{$cart_item->quantity}}" readonly>
                                                <button id="increment_{{$cart_item->id}}" type="button" onclick="increaseQuantity('{{$cart_item->id}}')">
                                                    +
                                                </button>
                                            </div>
                                            <span id="spinner{{$cart_item->id}}" class="spinner-border spinner-border-sm d-none" style="color:#ff8800" role="status" aria-hidden="true"></span>


                                            <p class="card-text fw-bold fs-3 cursor-pointer mt-auto text-success">{{$product->unitPrice}}
                                                ₺</p>
                                        </div>
                                    </div>
                                </li>
                                @if(!$loop->last)
                                    <hr class="w-100">
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-warning-subtle text-center">
                        Sipariş Özeti
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item border-0">
                                <div class="row">
                                    <div class="col-8">
                                    <span>
                                        Ürünlerin Toplamı :
                                    </span>
                                    </div>
                                    <div class="col-4">
                                    <span class="text-dark-emphasis fw-bold fs-5">
                                        {{$total_price}} ₺
                                    </span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0">
                                <div class="row">
                                    <div class="col-8">
                                    <span>
                                        İndirim :
                                    </span>
                                    </div>
                                    <div class="col-4">
                                    <span class="text-success fw-bold fs-5">
                                        0 ₺
                                    </span>
                                    </div>
                                </div>
                            </li>
                            <hr class="table-group-divider">
                            <li class="list-group-item border-0">
                                <div class="row">
                                    <div class="col-8">
                                    <span>
                                        Toplam :
                                    </span>
                                    </div>
                                    <div class="col-4">
                                    <span class="fw-bold text-success fs-5">
                                        {{$total_price}} ₺
                                    </span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <a href="{{route('address.select')}}" class="btn btn-warning" type="button">Sepeti Onayla</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>

        function increaseQuantity(cart_item_id) {
            document.getElementById('spinner' + cart_item_id).classList.remove('d-none');
            document.getElementById('quantity-selector-'+cart_item_id).classList.add('d-none');

            axios.post('/cart/increase', {
                cart_item_id: cart_item_id,
                _method: 'PUT'
            })
                .then(response => {
                    location.reload()
                })
                .catch(error => {
                    document.getElementById('spinner' + cart_item_id).classList.add('d-none');
                    document.getElementById('quantity-selector').classList.remove('d-none');
                    console.log(error);
                });
        }

        function decreaseQuantity(cart_item_id) {
            document.getElementById('spinner' + cart_item_id).classList.remove('d-none');
            document.getElementById('quantity-selector-'+cart_item_id   ).classList.add('d-none');
            if (document.getElementById('quantity_' + cart_item_id).value === '1' && !confirm('Ürünü silmek istediğinize emin misiniz?')) {
                return;
            }
            axios.post('/cart/decrease', {
                cart_item_id: cart_item_id,
                _method: 'PUT'
            }).then(response => {
                location.reload()
            }).catch(error => {
                document.getElementById('spinner' + cart_item_id).classList.add('d-none');
                document.getElementById('quantity-selector').classList.remove('d-none');
                console.log(error);
            });
        }
    </script>
@endsection
