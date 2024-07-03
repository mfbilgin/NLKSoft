@php use App\Models\Category; @endphp
@extends('layouts.admin')
@section('title','Add Product')
@section('styles')
    <style>
        .carousel-inner {
            width: 200px; /* Sabit genişlik */
            height: 250px; /* Sabit yükseklik */
        }

        .carousel-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Resmi kırpıp, alanı doldur */
        }
    </style>
@endsection
@section('admin-content')
    @php($categories = Category::all())
    <div class="text-center mb-5">
        <h1>Yeni Ürün Oluştur</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name') }}" placeholder="" required>
                        <label for="name">Ürün Adı</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="unitPrice" name="unitPrice"
                               value="{{ old('unitPrice') }}" placeholder="" required>
                        <label for="unitPrice">Adet Fiyatı</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="unitsInStock" name="unitsInStock"
                               value="{{ old('unitsInStock') }}" placeholder="" required>
                        <label for="unitsInStock">Stok Adedi</label>
                    </div>
                    <div class="mb-3">
                        <label for="description">Ürün Açıklaması</label>
                        <textarea class="form-control" id="description" name="description" placeholder="" rows="4"
                                  required>{{ old('description') }}</textarea>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="" selected disabled>Seçiniz</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <label for="category_id">Kategori</label>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Ürün Fotoğrafları</label>
                        <input type="file" class="form-control" id="images" name="images[]"
                               accept=".png, .jpg, .jpeg, .gif" multiple>
                    </div>
                    <div class="mb-3">
                        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="carousel-inner">
                                <!-- Resim önizlemeleri buraya eklenecek -->
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end"><i class="bi bi-plus-circle-dotted"></i>
                        Ürünü Ekle
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.getElementById('images').addEventListener('change', function (event) {
            const files = event.target.files;
            const carouselInner = document.getElementById('carousel-inner');
            carouselInner.innerHTML = '';
            for (let i = 0; i < files.length; i++) {

                const reader = new FileReader();
                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.className = 'carousel-item' + (i === 0 ? ' active' : '');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'd-block w-100';
                    div.appendChild(img);
                    carouselInner.appendChild(div);
                };
                reader.readAsDataURL(files[i]);
            }
        });
    </script>
@endsection

