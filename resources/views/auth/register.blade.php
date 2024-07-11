@extends('layouts.app')
@section('title','Register Page')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 offset-md-3">
                <div class="card mt-3" style="width: 100%;">
                    <div class="card-header text-center text-bg-success">
                        <h1>Kayıt</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                       value="{{ old('name') }}" placeholder="" required>
                                <label for="name">İsim Soyisim</label>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                       value="{{ old('email') }}" placeholder="" required>
                                <label for="email">Email</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                       value="{{ old('password') }}"
                                       placeholder="" required>
                                <label for="password">Parola</label>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-check form-switch" role="button">
                                    <input class="form-check-input" type="checkbox" id="show-password" role="button">
                                    <label class="form-check-label" for="show-password" role="button">
                                        Parolayı Göster
                                    </label>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                       name="password_confirmation" placeholder="" required>
                                <label for="password_confirmation">Parola Tekrar</label>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-warning  w-75">Kayıt Oluştur</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const showPasswordCheckbox = document.getElementById('show-password');
            const passwordInput = document.getElementById('password');

            showPasswordCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            });
        });
    </script>
@endsection
