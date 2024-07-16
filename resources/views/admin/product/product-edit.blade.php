@php use App\Models\Category; @endphp
@extends('layouts.admin')
@section('title',__('titles.titles.product_edit'))
@section('admin-content')
    @php($categories = Category::all())
    <div class="text-center mb-5">
        <h1>{{$product->name}} {{__('titles.general.update')}}</h1>
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
                        <label for="name">{{__('titles.product.name')}}</label>
                    </div>
                    <div class="mt-auto">
                        <label for="description">{{__('titles.product.description')}}</label>
                        <textarea class="form-control" id="description" name="description" placeholder=""
                                  rows="4"
                                  required>{{ $product->description }}</textarea>
                    </div>
                </div>
                <div class="col-6 d-flex flex-column">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="unitPrice" name="unitPrice"
                               value="{{ $product->unitPrice }}" placeholder="" required>
                        <label for="unitPrice">{{__('titles.product.price')}}</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="unitsInStock" name="unitsInStock"
                               value="{{ $product->unitsInStock }}" placeholder="" required>
                        <label for="unitsInStock">{{__('titles.product.stock')}}</label>
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
                        <label for="category_id">{{__('titles.product.category')}}</label>
                    </div>
                    <div class="mb-3 @if(count($product->images) == 5) d-none @endif">
                        <label for="images" class="form-label">{{__('titles.product.add_image')}}</label>
                        <input type="file" class="form-control" id="images" name="images[]"
                               accept=".png, .jpg, .jpeg, .gif, .webp" multiple>
                    </div>
                    <a id="update-button" class="btn btn-warning container-fluid float-end mt-auto"
                       onclick="sendForm()"><i
                            class="bi bi-pencil-square"></i> {{__('titles.general.update')}}
                    </a>
                </div>
            </div>
        </form>

        <div class="mt-4">
            <p class="text-black-50 text-center @if(count($product->images) == 0) d-none @endif">
                {{__('messages.product.click_for_delete')}}
            </p>
            <div class="container-fluid">

                @foreach($product->images as $image)
                    <div class="col-4 float-start">
                        <img src="{{asset($image->url)}}"
                             class="object-fit-scale delete-image mb-3 border border-2"
                             style="height: 200px; width: 90%; cursor:pointer; border-radius: 8px;
            padding: 5px;
            display: inline-block;"
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
        <div style="visibility: hidden;
            background-color: lightblue;
            padding: 20px;
            margin-top: 20px;">
            Boş alan
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

                reader.readAsDataURL(files[i]);
            }
        });

        const clearInput = function () {
            const input = document.getElementById('images');
            input.value = '';
        };

        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace("description");
            document.querySelectorAll('.delete-image').forEach(function (img) {
                img.addEventListener('click', function () {
                    if (confirm('{{__('messages.product.confirm_delete')}}')) {
                        img.nextElementSibling.submit();
                    }
                });
            })
        });
    </script>
@endsection

