@php use App\Models\CartItem;use App\Models\User; @endphp
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">{{env('APP_NAME')}}</a>
        <div>
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
                            <li><a class="dropdown-item" href="#">Bilgilerim</a></li>
                            <li><a class="dropdown-item" href="{{route('order.list')}}">Siparişlerim</a></li>
                            @if($user->isAdmin())
                                <li><a class="dropdown-item" href="/admin/dashboard">Admin</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Çıkış Yap</a></li>
                        </ul>
                    </div>
                </div>
            @else
                <div>
                    <a class="btn btn-success" href="{{ route('login') }}">Giriş Yap</a>
                    <a class="btn btn-warning" href="{{ route('register') }}">Kayıt Ol</a>
                </div>
            @endif
        </div>
    </div>
</nav>
