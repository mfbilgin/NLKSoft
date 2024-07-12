@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('title', 'Sipariş Detayı')
@section('styles')
    <style>
        span {
            font-weight: bold;
        }
        .product_name{
            text-decoration: none;
            color: black;
        }
        .product_name:hover{
            text-decoration: underline;
        }

    </style>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Sipariş Detayı</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Sipariş Bilgileri</h5>
                        @php
                            $created_at = Carbon::parse($order->created_at);
                            Carbon::setLocale('tr');
                            $created_at = $created_at->translatedFormat('d F Y - H:i');
                        @endphp
                        <p><span>Sipariş Tarihi: </span>{{$created_at}}</p>
                        <p><span>Sipariş Durumu: </span>{{$order->status}}</p>
                        <p><span>Toplam Tutar: </span>{{$order->total_amount}} ₺</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Alıcı Bilgileri</h5>
                        <p><span>Ad Soyad: </span>{{$order->user->name}}</p>
                        <p><span>Telefon: </span>{{$order->address->phone}}</p>
                        <p><span>Adres: </span> {{$order->address->address}}</p>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col">
                        <h5>Sipariş Detayı</h5>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Ürün</th>
                                <th>Adet</th>
                                <th>Fiyat</th>
                                <th>Toplam</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->order_items as $order_item)
                                <tr>
                                    <td><a class="product_name" href="{{route('product.detail',$order_item->product->id)}}">{{$order_item->product->name}}</a></td>
                                    <td>{{$order_item->quantity}}</td>
                                    <td>{{$order_item->price}} ₺</td>
                                    <td>{{$order_item->quantity * $order_item->price}} ₺</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
