@php use App\Models\Category; @endphp
@extends('layouts.admin')
@section('title','Add Category')
@section('admin-content')
    <div class="text-center mb-5">
        <h1>Yeni Kategori Oluştur</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <form action="{{route('category.store')}}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name') }}" placeholder="" required>
                        <label for="name">Kategori Adı</label>
                    </div>

                    <button type="submit" class="btn btn-primary float-end"><i class="bi bi-plus-circle-dotted"></i> Kategori Ekle</button>
                </form>
            </div>
        </div>
    </div>
@endsection
