@php use Carbon\Carbon; @endphp
{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Siparişlerim')

@section('styles')
    <style>
        p.text-small {
            font-size: 0.85rem;
        }

        div.card-header div.row div.col {
            margin-top: auto;
            margin-bottom: auto;
        }

        div.card-body div.row div.col-6 p.Hazırlanıyor {
            color: darkorange;
        }

        div.card-body div.row div.col-6 p.Kargoya.Verildi {
            color: darkgreen;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5" style="width: 70%">
        <h2 class=" mb-4">Siparişlerim</h2>
        @foreach($orders as $order)
            @php
                $created_at = Carbon::parse($order->created_at);
                Carbon::setLocale('tr');
                $created_at = $created_at->translatedFormat('d F Y - H:i');
            @endphp
            <div class="card mx-auto mb-3" style="width: 100%">
                <div class="card-header">
                    <div class="row text-start text-center d-flex justify-content-center">
                        <div class="col">
                            <p class="text-small fw-bold">Sipariş Tarihi</p>
                            <p class="text-small">{{$created_at}}</p>
                        </div>
                        <div class="col">
                            <p class="text-small fw-bold">Sipariş Özeti</p>
                            <p class="text-small">{{ $order->order_items()->count() }} Ürün</p>
                        </div>
                        <div class="col">
                            <p class="text-small fw-bold">Alıcı</p>
                            <p class="text-small">{{ $order->user->name }}</p>
                        </div>
                        <div class="col">
                            <p class="text-small fw-bold">Tutar</p>
                            <p class="text-small" style="color: darkorange">{{ $order->total_amount}} ₺</p>
                        </div>
                        <div class="col">
                            <a href="{{route('order.detail',$order->id)}}" class="btn btn-warning w-100">Sipariş Detayı</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class=" {{$order->status}}"> {{$order->status}}</p>
                            @if($order->status == 'Hazırlanıyor')
                                <p class="text-small">
                                    Tahmini Kargolama
                                    Tarihi: <span class="fw-bold">
                                        {{Carbon::parse($order->created_at)->addDays(2)->translatedFormat('d F Y')}}
                                    </span>
                                </p>
                            @elseif($order->status == 'Kargoya Verildi')
                                <p class="text-small">
                                    Tahmini Teslimat Tarihi:
                                    <span
                                        class="fw-bold">{{Carbon::parse($order->updated_at)->addDays(3)->translatedFormat('d F Y')}}</span>
                                </p>
                            @endif
                        </div>
                        <div class="col-6">
                            @php
                                $product_image_urls = array();
                                $product_ids = array();
                                    $order_items = $order->order_items()->get();
                                    foreach ($order_items as $order_item) {
                                    $product_image_urls[] = $order_item->product->images()->first()->url;
                                    $product_ids[] = $order_item->product->id;
                                    }
                            @endphp
                                <div class="d-flex">
                            @foreach($product_image_urls as $index => $product_image_url)
                                        <a href="{{route('product.detail',$product_ids[$index])}}">
                                            <img src="{{asset($product_image_url)}}" class="me-2" alt="Ürün Resmi" style="object-fit: cover;width: 50px; height: 64px;">
                                        </a>
                            @endforeach
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let status = document.querySelectorAll('.card-body .row .col-6 p');
            status.forEach(function (item) {
                if (item.textContent === ' Hazırlanıyor') {
                    item.classList.add('bi');
                    item.classList.add('bi-box2');
                } else if (item.textContent === ' Kargoya Verildi') {
                    item.classList.add('bi');
                    item.classList.add('bi-truck');
                } else if (item.textContent === 'Sipariş Tamamlandı') {
                    item.classList.add('bi');
                    item.classList.add('bi-check2-circle');
                }
            });
        })
    </script>
@endsection
