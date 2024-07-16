@php use App\Models\Category; @endphp
@extends('layouts.admin')
@section('title',__('titles.titles.categories'))
@section('admin-content')
    @php($categories = Category::orderBy('name','asc')->get())
    <div class="container text-center">
        <div>
            <a class="btn btn-primary float-end" href="{{route('admin.category.add')}}">
                <i class="bi bi-plus-circle-dotted"></i> {{__('titles.category.add')}}
            </a>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">{{__('titles.category.name')}}</th>
                    <th scope="col">#</th>
                    <th scope="col">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            <a href="{{route('category.edit', $category->id)}}" type="submit" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> {{__('titles.general.update')}}
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('category.delete', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash3"></i> {{__('titles.general.delete')}}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(count($categories) == 0)
                <div class="alert alert-warning" role="alert">
                    Kategori Bulunamadı
                </div>
            @endif
        </div>
    </div>
@endsection
