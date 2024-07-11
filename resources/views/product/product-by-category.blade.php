@extends('layouts.app')
@section('title',$products->first()->category->name.' Kategorisindeki Ürünler')
@section('content')
<div class="mt-5 container">

@include('product.show-products-layout')
</div>
@endsection
