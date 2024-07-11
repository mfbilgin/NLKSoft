@php
    function generate_stars($rating) {
        for ($i = 0; $i < $rating; $i++) {
            echo '<span class="bi bi-star-fill"></span>';
        }
        for ($i = 0; $i < 5 - $rating; $i++) {
            echo '<span class="bi bi-star"></span>';
        }
    }
@endphp
<div class="container border border-2 p-4 mb-5 mt-3">
    <div class="row text-center mb-4">
        @for($i = 5; $i>0;$i--)
            <div class="col">
                <button id="button_{{$i}}" class="btn border-1 border-black text-warning" style="border-radius: 5%">
                    @php
                        generate_stars($i);
                    @endphp
                    <span class="text-black">
                ({{($product->get_reviews_count_by_rating($i))}})</span>

                </button>
            </div>
        @endfor

    </div>
    @php
        $reviews = $product->reviews;
    @endphp
    @foreach($reviews as $review)
        @if($review->is_approved())
            <div class="container-fluid border border-1" style="border-radius: 6px">
                <div class="row">
                    <div class="col-6">
                        <p id="button_{{$i}}" class="float-start text-warning"
                           style="border-radius: 5%; cursor:auto">
                            @php
                                $user = $review->user;
                                generate_stars($review->rating);
                            @endphp
                        </p>
                    </div>
                    @if(auth()->check() && auth()->user()->id == $review->user_id)
                    <div class="col-6 mt-2">
                        <form action="{{route('review.delete',$review->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="review_id" value="{{$review->id}}">
                            <button type="submit" class="btn btn-danger bi bi-trash3 float-end">Sil</button>
                        </form>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">

                        <p class="text-muted">{{$user->name}}</p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p class="text-muted text-end">{{(new DateTime($review->created_at))->format('d F Y')}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>
                            {{$review->review}}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
