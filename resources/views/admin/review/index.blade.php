@php use App\Models\ProductReview;use App\Models\User; @endphp
@extends('layouts.admin')
@section('title',__('titles.titles.reviews'))
@section('admin-content')
    @php($reviews = ProductReview::all())
    <div class="container text-center">
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">{{__('titles.review.rating')}}</th>
                    <th scope="col">{{__('titles.review.comment')}}</th>
                    <th scope="col">{{__('titles.review.user')}}</th>
                    <th scope="col">{{__('titles.review.product')}}</th>
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
                                <button type="submit"
                                        class="btn btn-success @if($review->is_approved()) disabled @endif">
                                    <i class="bi bi-check-circle"></i> {{__('titles.review.approve')}}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.review.delete', $review->id) }}" method="POST">
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
        </div>
    </div>
@endsection
