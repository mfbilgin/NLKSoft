@php use App\Models\Category; @endphp
@extends('layouts.admin')
@section('title','Edit Product')
@section('admin-content')
    @php($categories = Category::all())
    <div class="text-center mb-5">
        <h1>{{$product->name}} Ürününü Güncelle</h1>
    </div>
    <div class="container-fluid">
        <form action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data"
              id="update-form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-6 d-flex flex-column">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ $product->name }}" placeholder="" required>
                        <label for="name">Ürün Adı</label>
                    </div>
                    <div class="mt-auto">
                        <label for="description">Ürün Açıklaması</label>
                        <textarea class="form-control" id="description" name="description" placeholder=""
                                  rows="4"
                                  required>{{ $product->description }}</textarea>
                    </div>
                </div>
                <div class="col-6 d-flex flex-column">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="unitPrice" name="unitPrice"
                               value="{{ $product->unitPrice }}" placeholder="" required>
                        <label for="unitPrice">Adet Fiyatı</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="unitsInStock" name="unitsInStock"
                               value="{{ $product->unitsInStock }}" placeholder="" required>
                        <label for="unitsInStock">Stok Adedi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="{{$product->category->id}}" selected>{{$product->category->name}}</option>
                            @foreach($categories as $category)
                                @if($category->id != $product->category->id )
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="category_id">Kategori</label>
                    </div>
                    <div class="mb-3 @if(count($product->images) == 5) d-none @endif">
                        <label for="images" class="form-label">Yeni fotoğraf ekle</label>
                        <input type="file" class="form-control" id="images" name="images[]"
                               accept=".png, .jpg, .jpeg, .gif, .webp" multiple>
                    </div>
                    <a id="update-button" class="btn btn-warning container-fluid float-end mt-auto"
                       onclick="sendForm()"><i
                            class="bi bi-pencil-square"></i> Ürünü Güncelle
                    </a>
                </div>
            </div>
        </form>

        <div class="mt-4">
            <p class="text-black-50 text-center @if(count($product->images) == 0) d-none @endif">Silmek
                istediğiniz resmin üzerine tıklayın</p>
            <div class="container-fluid">

                @foreach($product->images as $image)
                    <div class="col-4 float-start">
                        <img src="{{asset($image->url)}}"
                             class="object-fit-scale delete-image"
                             style="width: 100%; height: 200px; cursor:pointer"
                             alt="{{$product->name}} fotoğrafı">
                        <form id="delete-form"
                              action="{{ route('image.delete', $image->id) }}"
                              method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const sendForm = function () {
            console.log('update button clicked');
            document.getElementById('update-form').submit();
        };
        document.getElementById('images').addEventListener('change', function (event) {
            const files = event.target.files;

            const allowedExtensions = ['image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'image/webp'];
            const alreadyExistImages = document.querySelectorAll('.delete-image');
            console.log(alreadyExistImages.length)
            if (files.length + alreadyExistImages.length > 5) {
                alert('En fazla 5 resim ekleyebilirsin.');
                clearInput()
                return;
            }
            for (let i = 0; i < files.length; i++) {
                if (!allowedExtensions.includes(files[i].type)) {
                    alert('Sadece jpg, png, jpeg ve gif formatlarında resim ekleyebilirsiniz.');
                    clearInput()
                    break;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgElement = new Image();
                    imgElement.onload = function () {
                        const width = imgElement.width;
                        const height = imgElement.height;
                        const aspectRatio = width / height;
                        if (aspectRatio < 0.75 || aspectRatio > 1.25) {
                            alert('Resmin genişlik ve yükseklik oranı 0.75 ile 1.25 arasında olmalıdır.');
                            clearInput()
                        }
                    };
                    imgElement.src = e.target.result;
                };
                reader.readAsDataURL(files[i]);
            }
        });

        const clearInput = function () {
            const input = document.getElementById('images');
            input.value = '';
        };

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-image').forEach(function (img) {
                img.addEventListener('click', function () {
                    if (confirm('Bu resmi silmek istediğinize emin misiniz?')) {
                        img.nextElementSibling.submit();
                    }
                });
            })
        });
    </script>
@endsection

