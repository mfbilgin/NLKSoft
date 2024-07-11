@php use App\Models\ProductReview;use App\Models\User; @endphp
@extends('layouts.admin')
@section('title','Reviews')
@section('admin-content')
    @php($reviews = (new ProductReview())->get_waiting())
    <div class="container text-center">
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Puan</th>
                    <th scope="col">Yorum</th>
                    <th scope="col">Kullanıcı Adı</th>
                    <th scope="col">Ürün Adı</th>
                    <th scope="col">#</th>
                    <th scope="col">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td>{{$review->rating}}</td>
                        <td>{{$review->review}}</td>
                        <td>{{$review->user->name}}</td>
                        <td>{{$review->product->name}}</td>
                        <td>

                            <form
                                action="{{ route('admin.review.approve',$review->id)}}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Onayla
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.review.delete', $review->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash3"></i> Yorumu Sil
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
