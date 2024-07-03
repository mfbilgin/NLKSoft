<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">MFBILGIN</a>
        <div>
            @if(auth()->check())
                @php $user = \App\Models\User::find(auth()->id()) @endphp
                <div>
                    <div class="dropdown  me-1">
                        <button class="btn dropdown-toggle border-0" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            {{ $user->name}}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end w-100 text-center">
                            <li><a class="dropdown-item" href="#">Bilgilerim</a></li>
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
