@extends('layouts.app')
@section('title',__('titles.dashboard.dashboard'))
@section('style')
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            background-color: #343a40;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
        }

        .sidebar .nav-item {
            width: 100%;
        }

        .sidebar .nav-item .nav-link {
            padding: 1rem;
        }

        .content {
            margin-left: 250px;
            padding: 2rem;
        }
    </style>
@endsection
@section('content')
    <div class="sidebar px-3 align-content-around my-auto">
        <div>
            <div class="d-flex flex-column mb-3 text-white text-decoration-none fs-5 my-auto">
                <a href="{{route('home')}}" class="align-items-center text-white text-decoration-none">
                    <i class="bi bi-house"></i>
                    <span class="ms-3">{{__('titles.dashboard.return_to_home')}}</span>
                </a>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto my-auto">
                <li class="nav-item">
                    <p class="d-inline-flex gap-1">
                        <button class="btn border-0 text-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseProducts" aria-expanded="false"
                                aria-controls="collapseProducts">
                            {{__('titles.dashboard.product.product_management')}}
                        </button>
                    </p>
                    <div class="collapse" id="collapseProducts">
                        <div class="card card-body bg-dark">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{route('admin.product.list')}}" class="nav-link text-white">
                                        {{__('titles.dashboard.product.products')}}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('admin.product.add')}}" class="nav-link text-white">
                                        {{__('titles.dashboard.product.product_add')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <p class="d-inline-flex gap-1">
                        <button class="btn border-0 text-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseReviews" aria-expanded="false" aria-controls="collapseReviews">
                            {{__('titles.dashboard.review.review_management')}}
                        </button>
                    </p>
                    <div class="collapse" id="collapseReviews">
                        <div class="card card-body bg-dark">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{route('admin.review.waiting.list')}}" class="nav-link text-white">
                                        {{__('titles.dashboard.review.waiting_reviews')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.review.list')}}" class="nav-link text-white">
                                        {{__('titles.dashboard.review.reviews')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <p class="d-inline-flex gap-1">
                        <button class="btn border-0 text-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseCategories" aria-expanded="false"
                                aria-controls="collapseCategories">
                            {{__('titles.dashboard.category.category_management')}}
                        </button>
                    </p>
                    <div class="collapse" id="collapseCategories">
                        <div class="card card-body bg-dark">
                            <ul class="list-unstyled ">
                                <li>
                                    <a href="{{route('admin.category.list')}}" class="nav-link text-white">
                                        {{__('titles.dashboard.category.categories')}}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('admin.category.add')}}" class="nav-link text-white">
                                        {{__('titles.dashboard.category.category_add')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <p class="d-inline-flex gap-1">
                        <button class="btn border-0 text-white" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                            {{__('titles.dashboard.user.user_management')}}
                        </button>
                    </p>
                    <div class="collapse" id="collapseUsers">
                        <div class="card card-body bg-dark">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{route('admin.user.list')}}" class="nav-link text-white">
                                        {{__('titles.dashboard.user.users')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>

    <div class="content">
        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                @foreach($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
                {{session('info')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('admin-content')
    </div>
@endsection
