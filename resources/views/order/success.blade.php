@php use App\Models\Order; @endphp
@extends('layouts.app')

@section('title', 'Ödeme Başarılı')

@section('styles')
    <style>
        .success-container {
            margin-top: 50px;
            text-align: center;
        }

        .success-icon {
            font-size: 100px;
            color: green;
        }

        .success-message {
            font-size: 24px;
            margin-top: 20px;
        }

        .order-details {
            margin-top: 30px;
            text-align: left;
        }
    </style>
@endsection

@section('content')
    @php
        if (!session('order_id')) {
            return redirect()->back();
        }
        $order = Order::where('id', session('order_id'))->first()
    @endphp
    <div class="container success-container">
        <i class="bi bi-check-circle-fill success-icon"></i>
        <div class="success-message">
            Ödemeniz başarıyla tamamlandı!
        </div>
        <div class="order-details">
            <h3>Sipariş Detayları</h3>
            <p><strong>Sipariş Numarası:</strong> {{ $order->id }}</p>
            <p><strong>Tarih:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Tutar:</strong> {{ number_format($order->total, 2) }} TL</p>
            <h4>Kargo Adresi</h4>
            <p>{{ $order->address->contact_name }}</p>
            <p>{{ $order->address->address }}</p>
            <p>{{ $order->address->city }}, {{ $order->address->zip_code }}</p>
            <p>{{ $order->address->phone }}</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary mt-4">Anasayfaya Dön</a>
    </div>
@endsection
