@extends('layouts.admin')
@section('title','Edit Category')
@section('admin-content')
    <div class="text-center mb-5">
        <h1>{{$category->name}} kategorisini düzenle</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <form action="{{route('category.update',$category->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ $category->name }}" placeholder="" required>
                        <label for="name">Kategori Adı</label>
                    </div>

                    <button type="submit" class="btn btn-warning float-end"><i class="bi bi-pencil-square"></i> Güncelle</button>
                </form>
            </div>
        </div>
    </div>
@endsection
