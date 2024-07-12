@extends('layouts.app')
@section('title','Adreslerim')
@section('styles_and_links')
    <style>
        .address-card {
            margin-bottom: 20px;
            height: 310px;
        }

        .custom-radio {
            display: flex;
            align-items: center;
        }

        .custom-radio input {
            margin-right: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="container mt-5">
        <form id="address-form" action="{{route('checkout.address.add')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-sm-3">
                    <div class="card address-card">
                        <div class="card-body text-center">
                            <a href="{{route('address.create')}}" class="btn border-0 bi bi-plus-circle d-block"></a>
                            <a href="{{route('address.create')}}" class="text-decoration-none text-dark">Yeni Adres Ekle</a>
                        </div>
                    </div>
                </div>
                @foreach ($addresses as $address)
                    <div class="col-md-4">
                        <div class="card address-card mb-sm-3" style="height: 330px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $address->address_name }}</h5>
                                <p class="card-text text-muted">{{ $address->contact_name }}</p>
                                <p class="card-text">{{ $address->address}} / {{$address->zip_code}}</p>
                                <p class="card-text">{{ $address->city }}</p>
                                <p class="card-text">{{ $address->phone }}</p>
                                <div class="custom-radio">
                                    <input type="radio" name="selected_address" value="{{ $address->id }}"
                                           id="address{{ $address->id }}">
                                    <label for="address{{ $address->id }}">Adresi Seç</label>
                                </div>
                                <a href="{{ route('address.edit', $address->id) }}"
                                   class="btn btn-outline-primary bi bi-pencil-square float-end mt-auto"> Adresi Düzenle</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button id="submit-button" type="submit" class="btn btn-warning w-25 float-end mt-3">Adresi Onayla</button>
        </form>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $('#address-form').on('submit', function (event) {
            event.preventDefault();
            let selectedAddressId = $('input[name="selected_address"]:checked').val();
            if (selectedAddressId) {
                $.post($(this).attr('action'), $(this).serialize(), function(response) {
                    window.location.href = '{{route('checkout')}}';
                });
            }
        });

    </script>
@endsection
