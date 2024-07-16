@php use App\Models\CartItem;use App\Models\User; @endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css"/>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">{{env('APP_NAME')}}</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown dropdown-center">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-globe"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('lang', 'tr')}}">
                                <i class="fi fi-tr"></i> Türkçe</a>
                        </li>
                        <li><a class="dropdown-item" href="{{route('lang', 'en')}}">
                                <i class="fi fi-gb"></i> English</a>
                        </li>
                    </ul>
                </li>
            </ul>
            @if(auth()->check())
                @php $user = User::find(auth()->id()) @endphp
                <div>
                    <div class="dropdown  me-1">
                        <a href="{{route('cart.index')}}" class="text-decoration-none">
                            <button type="button" class="btn border border-1 border-warning position-relative mt-1">
                                <i class="bi bi-cart-fill text-warning fs-4"></i>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{count($cart_items = CartItem::where('cart_id',auth()->user()->cart->id)->get())}}
                                     <span class="visually-hidden">Sepetteki ürünler</span>
                                 </span>
                            </button>
                        </a>
                        <button class="btn dropdown-toggle border-0" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            {{ $user->name}}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end w-100 text-center">
                            <li><a class="dropdown-item" href="#">{{__('titles.navbar.dropdown.profile')}}</a></li>
                            <li><a class="dropdown-item"
                                   href="{{route('order.list')}}">{{__('titles.navbar.dropdown.orders')}}</a></li>
                            @if($user->isAdmin())
                                <li><a class="dropdown-item"
                                       href="/admin/dashboard">{{__('titles.navbar.dropdown.dashboard')}}</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item"
                                   href="{{ route('logout') }}">{{__('titles.navbar.dropdown.logout')}}</a></li>
                        </ul>
                    </div>
                </div>
            @else
                <div>
                    <a class="btn btn-success" href="{{ route('login') }}">{{__('titles.auth.login')}}</a>
                    <a class="btn btn-warning" href="{{ route('register') }}">{{__('titles.auth.register')}}</a>
                </div>
            @endif
        </div>
    </div>
</nav>
