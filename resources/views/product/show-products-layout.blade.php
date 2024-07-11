<style>
    .card-title:hover {
        text-decoration: underline;
    }

    .card {
        cursor: pointer;
        width: 18rem;
    }

    .card-img-top {
        height: 250px;
        object-fit: cover;
    }

    .card-body {
        height: 125px;
        overflow: hidden;
        display: flex;
        flex-direction: column; /* İçerikleri dikey hizala */
        justify-content: space-between; /* İçerikleri aralarında boşluk bırakarak dikey hizala */
    }

    .card-body .card-title {
        margin-bottom: 0; /* Card başlığının altındaki boşluğu kaldır */
    }

    .card-body .card-text {
        margin-top: auto; /* Fiyat metnini alt sınırda hizala */
    }

    .card-footer {
        padding-top: 10px;
    }
</style>

<div class="row">
    @foreach($products as $product)
        <div class="col-lg-4 col-md-6 mb-4 center">
            <div class="card mx-auto">
                <div id="{{$product->id}}Carousel" class="carousel slide">
                    <div class="carousel-inner" id="carousel-inner">
                        @foreach($product->images as $key => $image)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <img src="{{asset($image->url)}}"
                                     style="width: 100%; height: 250px;object-fit: contain"
                                     alt="{{$product->name}}" class="card-img-top">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev @if(count($product->images)==1) d-none @endif"
                            type="button" data-bs-target="#{{$product->id}}Carousel"
                            data-bs-slide="prev">
                                <span class="bi bi-arrow-left-circle-fill text-black fs-2" style="border-radius: 25%"
                                      aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next  @if(count($product->images)==1) d-none @endif"
                            type="button" data-bs-target="#{{$product->id}}Carousel"
                            data-bs-slide="next">
                                    <span class="bi bi-arrow-right-circle-fill text-black fs-2"
                                          aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title"
                        onclick="redirectToLink('{{route('product.detail',$product->id)}}')">
                        {{ Str::limit($product->name, 45, '...') }}
                    </h5>
                    <p class="card-text fs-5 text-success-emphasis"> {{$product->unitPrice}} ₺</p>
                </div>
                <div class="card-footer text-center">
                    <form action="{{route('cart.add')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button class="bi bi-cart-plus-fill  btn btn-success" type="submit">
                            Sepete Ekle
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>


<script>
    function redirectToLink(url) {
        window.location.href = url;
    }

    function checkForm() {
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');
        const categoryInput = document.getElementById('category_id');


        if (categoryInput.value === '') {
            categoryInput.disabled = true;
        }

        if (!minPriceInput.value && maxPriceInput.value) {
            minPriceInput.value = 0;
        }

        if (!minPriceInput.value || minPriceInput.value < 0) {
            minPriceInput.disabled = true;
        }

        if (!maxPriceInput.value || maxPriceInput.value <= 0) {
            maxPriceInput.disabled = true;
        }


        if (parseInt(maxPriceInput.value) < parseInt(minPriceInput.value)) {
            showAlert('En yüksek fiyat en düşük fiyattan küçük olamaz!');
            enableAllInputs();
            return false;
        }
        return true;
    }

    function enableAllInputs() {
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');
        const categoryInput = document.getElementById('category_id');
        minPriceInput.disabled = false;
        maxPriceInput.disabled = false;
        categoryInput.disabled = false;
    }

    function showAlert(message) {
        const alert = document.querySelector('.alert-list');
        alert.querySelector('.alert-text').innerHTML = message;
        alert.classList.remove('d-none');
    }

    function clearFilter() {
        const form = document.getElementById('filter_form');

        form.querySelectorAll('input,select').forEach(function (element) {
            element.value = '';
        })
    }
</script>
