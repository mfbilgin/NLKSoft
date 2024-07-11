@extends('layouts.app')
@section('title','Verify Page')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header text-center">E posta adresini doğrula</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('E-posta adresinize yeni bir doğrulama bağlantısı gönderildi.') }}
                            </div>
                        @endif

                        Devam etmeden önce, lütfen doğrulama bağlantısı için e-postanızı kontrol edin.
                        Eğer e-postayı almadıysanız,
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                    class="btn btn-link p-0 m-0 align-baseline">Yeni bir tane göndermek için tıklayın</button>
                            .
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
