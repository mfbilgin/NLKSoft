    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    @yield('style')

</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">MFBILGIN</a>
            <div>
                @if(auth()->check())
                    @php $user = \App\Models\User::find(auth()->id()) @endphp
                    <div>
                        {{--                        <a class="btn btn-danger" href="{{ route('logout') }}">Çıkış Yap</a>--}}
                        <div class="dropdown me-1">
                            <button class="btn dropdown-toggle border-0" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                {{ $user->name}}
                            </button>
                            <ul class="dropdown-menu w-100 text-center">
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
</header>

<main>
    @yield('content')
</main>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>
</html>
