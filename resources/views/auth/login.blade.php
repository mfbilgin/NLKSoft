@extends('layouts.app')
@section('title','Login Page')
@section('content')
    @if(session('error'))
        {
        <div class="text-center alert alert-danger mx-auto w-50" role="alert">
            {{session('error')}}
        </div>
        }
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 offset-md-3">
                <div class="card mt-3" style="width: 100%;">
                    <div class="card-header text-center text-bg-warning">
                        <h1>Giriş</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email') }}" placeholder="" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                       value="{{ old('password') }}"
                                       placeholder="" required>
                                <label for="password">Parola</label>
                                <div class="form-check form-switch" role="button">
                                    <input class="form-check-input" type="checkbox" id="show-password" role="button">
                                    <label class="form-check-label" for="show-password" role="button">
                                        Parolayı Göster
                                    </label>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success  w-75">Giriş Yap</button>
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
