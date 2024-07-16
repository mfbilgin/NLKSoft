@php use App\Models\Category;use App\Models\Product;use Illuminate\Support\Str; @endphp
@extends('layouts.app')
@section('title',__('titles.titles.home'))
@section('content')
    @php($categories = Category::all())
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
                <form action="{{route('home')}}" method="GET" onsubmit="return checkForm()" id="filter_form">
                    <ul class="list-group">
                        <li class="list-group-item disabled bg-primary-subtle text-center">
                            {{__('titles.home.filtering.filtering')}}
                        </li>
                        <li class="list-group-item">
                            <label for="category_id">{{__('titles.home.filtering.category')}}</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">{{__('titles.home.filtering.all')}}</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                            @if(request()->get('category_id') == $category->id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="list-group-item">
                            <label class="mb-1">{{__('titles.home.filtering.price_range')}}</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" value="{{request()->get('min_price')}}"
                                               class="form-control" name="min_price" id="min_price" placeholder="10">
                                        <label for="min_price">{{__('titles.home.filtering.least')}}</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" value="{{request()->get('max_price')}}"
                                               class="form-control" name="max_price" id="max_price" placeholder="10">
                                        <label for="max_price">{{__('titles.home.filtering.most')}}</label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item alert-list d-none">
                            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                <p class="alert-text">Hata mesajı buraya geliyor.</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        </li>
                        @if(count(request()->query()))
                            <li class="list-group-item clear-list">
                                <button onclick="clearFilter()" type="button"
                                        class="btn btn-danger bi bi-x-circle w-100"> {{__('titles.home.filtering.clear_filter')}}
                                </button>
                            </li>
                        @endif
                        <li class="list-group-item">
                            <button type="submit" class="btn btn-warning bi bi-filter w-100"> {{__('titles.home.filtering.filter')}}</button>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="col-md-9">
                @include('product.show-products-layout')
            </div>
        </div>
    </div>
@endsection
