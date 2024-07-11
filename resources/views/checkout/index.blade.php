@extends('layouts.app')
@section('title','Ödeme Sayfası')
@section('content')
@php
    include base_path('iyzipay-php-master/samples/initialize_checkout_form.php')
@endphp
@endsection
