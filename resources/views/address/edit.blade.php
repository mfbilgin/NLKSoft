@extends('layouts.app')
@section('title','Adres Düzenleme Sayfası')

@section('content')
    <div class="container mt-5 w-50">

        <div class="card">
            <div class="card-title">
                <div class="row">
                    <div class="col-8">
                        <h5 class="mt-2 ms-2">Adres Düzenleme</h5>
                    </div>
                    <div class="col-4">
                        @if(session('status'))
                            <a href="{{route('address.select')}}" class="btn btn-primary mt-2 me-2 float-end">Adres Seçimine Git</a>
                        @else
                            <form action="{{route('address.destroy',$address->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="from_select" value="true">
                                <button type="submit" class="btn btn-danger mt-2 me-2 float-end">Adresi Sil</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('address.update',$address->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="text" value="{{$address->contact_name}}"
                                       class="form-control @error('contact_name') is-invalid @enderror"
                                       id="contact_name" name="contact_name" placeholder="contact_name"
                                       autocomplete="contact_name"
                                >
                                <label for="contact_name">İsim Soyisim</label>
                                @error('contact_name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input value="{{$address->identity_number}}" type="text" maxlength="11"
                                       class="form-control @error('identity_number') is-invalid @enderror"
                                       id="identity_number"
                                       name="identity_number"
                                       autocomplete="identity_number"
                                       placeholder="identity_number">
                                <label for="identity_number">T.C. Kimlik Numarası</label>
                                @error('identity_number')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-floating">
                                <input maxlength="11" type="tel"
                                       class="form-control @error('phone') is-invalid @enderror " id="phone"
                                       name="phone"
                                       placeholder="phone"
                                       autocomplete="phone"
                                       value="{{$address->phone}}"
                                >
                                <label for="phone">Telefon Numarası</label>
                                @error('phone')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select @error('city') is-invalid @enderror" id="city" name="city"
                                        required>
                                    <option value="" selected disabled>Seçiniz</option>
                                    <option value="Adana">Adana</option>
                                    <option value="Adıyaman">Adıyaman</option>
                                    <option value="Afyonkarahisar">Afyonkarahisar</option>
                                    <option value="Ağrı">Ağrı</option>
                                    <option value="Aksaray">Aksaray</option>
                                    <option value="Amasya">Amasya</option>
                                    <option value="Ankara">Ankara</option>
                                    <option value="Antalya">Antalya</option>
                                    <option value="Ardahan">Ardahan</option>
                                    <option value="Artvin">Artvin</option>
                                    <option value="Aydın">Aydın</option>
                                    <option value="Balıkesir">Balıkesir</option>
                                    <option value="Bartın">Bartın</option>
                                    <option value="Batman">Batman</option>
                                    <option value="Bayburt">Bayburt</option>
                                    <option value="Bilecik">Bilecik</option>
                                    <option value="Bingöl">Bingöl</option>
                                    <option value="Bitlis">Bitlis</option>
                                    <option value="Bolu">Bolu</option>
                                    <option value="Burdur">Burdur</option>
                                    <option value="Bursa">Bursa</option>
                                    <option value="Çanakkale">Çanakkale</option>
                                    <option value="Çankırı">Çankırı</option>
                                    <option value="Çorum">Çorum</option>
                                    <option value="Denizli">Denizli</option>
                                    <option value="Diyarbakır">Diyarbakır</option>
                                    <option value="Düzce">Düzce</option>
                                    <option value="Edirne">Edirne</option>
                                    <option value="Elazığ">Elazığ</option>
                                    <option value="Erzincan">Erzincan</option>
                                    <option value="Erzurum">Erzurum</option>
                                    <option value="Eskişehir">Eskişehir</option>
                                    <option value="Gaziantep">Gaziantep</option>
                                    <option value="Giresun">Giresun</option>
                                    <option value="Gümüşhane">Gümüşhane</option>
                                    <option value="Hakkari">Hakkari</option>
                                    <option value="Hatay">Hatay</option>
                                    <option value="Iğdır">Iğdır</option>
                                    <option value="Isparta">Isparta</option>
                                    <option value="İstanbul">İstanbul</option>
                                    <option value="İzmir">İzmir</option>
                                    <option value="Kahramanmaraş">Kahramanmaraş</option>
                                    <option value="Karabük">Karabük</option>
                                    <option value="Karaman">Karaman</option>
                                    <option value="Kars">Kars</option>
                                    <option value="Kastamonu">Kastamonu</option>
                                    <option value="Kayseri">Kayseri</option>
                                    <option value="Kırıkkale">Kırıkkale</option>
                                    <option value="Kırklareli">Kırklareli</option>
                                    <option value="Kırşehir">Kırşehir</option>
                                    <option value="Kilis">Kilis</option>
                                    <option value="Kocaeli">Kocaeli</option>
                                    <option value="Konya">Konya</option>
                                    <option value="Kütahya">Kütahya</option>
                                    <option value="Malatya">Malatya</option>
                                    <option value="Manisa">Manisa</option>
                                    <option value="Mardin">Mardin</option>
                                    <option value="Mersin">Mersin</option>
                                    <option value="Muğla">Muğla</option>
                                    <option value="Muş">Muş</option>
                                    <option value="Nevşehir">Nevşehir</option>
                                    <option value="Niğde">Niğde</option>
                                    <option value="Ordu">Ordu</option>
                                    <option value="Osmaniye">Osmaniye</option>
                                    <option value="Rize">Rize</option>
                                    <option value="Sakarya">Sakarya</option>
                                    <option value="Samsun">Samsun</option>
                                    <option value="Siirt">Siirt</option>
                                    <option value="Sinop">Sinop</option>
                                    <option value="Sivas">Sivas</option>
                                    <option value="Şanlıurfa">Şanlıurfa</option>
                                    <option value="Şırnak">Şırnak</option>
                                    <option value="Tekirdağ">Tekirdağ</option>
                                    <option value="Tokat">Tokat</option>
                                    <option value="Trabzon">Trabzon</option>
                                    <option value="Tunceli">Tunceli</option>
                                    <option value="Uşak">Uşak</option>
                                    <option value="Van">Van</option>
                                    <option value="Yalova">Yalova</option>
                                    <option value="Yozgat">Yozgat</option>
                                    <option value="Zonguldak">Zonguldak</option>
                                </select>
                                <label for="city">Şehir</label>
                            </div>
                            @error('city')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating">
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                  name="address" placeholder="address" autocomplete="address"
                        >{{$address->address}}</textarea>
                                <label for="address">Adres</label>
                            </div>
                            @error('address')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('zip_code') is-invalid @enderror"
                                       id="zip_code" name="zip_code"
                                       placeholder="zip_code"
                                       value="{{$address->zip_code}}"
                                       autocomplete="zip_code">
                                <label for="zip_code">Posta Kodu</label>
                                @error('zip_code')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('address_name') is-invalid @enderror"
                                       id="address_name" name="address_name"
                                       value="{{$address->address_name}}"
                                       placeholder="address_name">
                                <label for="address_name">Adres Başlığı</label>
                                @error('address_name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
