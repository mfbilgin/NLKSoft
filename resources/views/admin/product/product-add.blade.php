@php use App\Models\Category; @endphp
@extends('layouts.admin')
@section('title',__('titles.titles.product_add'))
@section('admin-content')
    @php($categories = Category::all())
    <div class="text-center mb-5">
        <h1>{{__('titles.product.add')}}</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name') }}" placeholder="" required>
                        <label for="name">{{__('titles.product.name')}}</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="unitPrice" name="unitPrice"
                               value="{{ old('unitPrice') }}" placeholder="" required>
                        <label for="unitPrice">{{__('titles.product.price')}}</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="unitsInStock" name="unitsInStock"
                               value="{{ old('unitsInStock') }}" placeholder="" required>
                        <label for="unitsInStock">{{__('titles.product.stock')}}</label>
                    </div>
                    <div class="mb-3">
                        <label for="description">{{__('titles.product.description')}}</label>
                        <textarea class="form-control" id="description" name="description" placeholder="" rows="4"
                                  required>{{ old('description') }}</textarea>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="" selected disabled>{{__('titles.product.select')}}</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <label for="category_id">{{__('titles.product.category')}}</label>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">{{__('titles.product.photos')}}</label>
                        <input type="file" class="form-control" id="images" name="images[]"
                               accept=".png, .jpg, .jpeg, .gif, .webp" multiple>
                    </div>
                    <div class="mb-3 col-6 offset-3" style="display: none" id="carousel-collapse-div">
                        <div id="productCarousel" class="carousel slide " data-bs-ride="carousel">
                            <div class="carousel-inner" id="carousel-inner">
                                <!-- Resim önizlemeleri buraya eklenecek -->
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                    data-bs-slide="prev">
                                <span class="bi bi-arrow-left-circle-fill text-black fs-2" style="border-radius: 25%"
                                      aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                    data-bs-slide="next">
                                <span class="bi bi-arrow-right-circle-fill text-black fs-2" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end"><i class="bi bi-plus-circle-dotted"></i>
                        {{__('titles.general.add')}}
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
            if (files.length > 0) {
                document.getElementById('carousel-collapse-div').style.display = 'block';
            }
            const carouselInner = document.getElementById('carousel-inner');
            const allowedExtensions = ['image/jpg', 'image/png', 'image/jpeg', 'image/gif', 'image/webp'];
            carouselInner.innerHTML = '';
            if (files.length > 5) {
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
                    const div = document.createElement('div');
                    div.className = 'carousel-item' + (i === 0 ? ' active' : '');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'card-img  object-fit-scale';
                    img.style.width = '100%';
                    img.style.height = '300px';
                    div.appendChild(img);
                    carouselInner.appendChild(div);
                };
                reader.readAsDataURL(files[i]);
            }
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            CKEDITOR.replace("description");
            clearInput()
        })

        const clearInput = function () {
            const input = document.getElementById('images');
            input.value = '';
            document.getElementById('carousel-collapse-div').style.display = 'none';
        };
    </script>
@endsection

