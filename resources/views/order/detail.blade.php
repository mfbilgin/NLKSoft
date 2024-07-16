@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('title', __('titles.titles.order_detail'))
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
                <h4>{{__('titles.order.detail')}}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{__('titles.order.infos')}}</h5>
                        @php
                            $created_at = Carbon::parse($order->created_at);
                            Carbon::setLocale('tr');
                            $created_at = $created_at->translatedFormat('d F Y - H:i');
                        @endphp
                        <p><span>{{__('titles.order.date')}}: </span>{{$created_at}}</p>
                        <p><span>{{__('titles.order.status')}}: </span>{{$order->status}}</p>
                        <p><span>{{__('titles.order.amount')}}: </span>{{$order->total_amount}} ₺</p>
                    </div>
                    <div class="col-md-6">
                        <h5>{{__('titles.order.buyer_infos')}}</h5>
                        <p><span>{{__('titles.user.name')}}: </span>{{$order->user->name}}</p>
                        <p><span>{{__('titles.address.phone')}}: </span>{{$order->address->phone}}</p>
                        <p><span>{{__('titles.address.address')}}: </span> {{$order->address->address}}</p>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col">
                        <h5>{{__('titles.order.detail')}}</h5>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('titles.order.product')}}</th>
                                <th>{{__('titles.order.quantity')}}</th>
                                <th>{{__('titles.order.price')}}</th>
                                <th>{{__('titles.order.total')}}</th>
                            </tr>s
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
