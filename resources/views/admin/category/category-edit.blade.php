@extends('layouts.admin')
@section('title',__('titles.titles.category_edit'))
@section('admin-content')
    <div class="text-center mb-5">
        <h1>{{$category->name}} {{__('titles.general.update')}}</h1>
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
                        <label for="name">{{__('titles.category.name')}}</label>
                    </div>

                    <button type="submit" class="btn btn-warning float-end"><i class="bi bi-pencil-square"></i> {{__('titles.general.update')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
