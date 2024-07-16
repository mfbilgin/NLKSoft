<div class="container border border-2 p-4">
    <form action="{{route('review.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="review">{{__('titles.review.your_review')}}</label>
            <textarea name="review" class="form-control @error('review') is-invalid @enderror" id="review" rows="3"></textarea>
            @error('review')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="row mt-3 align-items-center">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rating">{{__('titles.review.your_rating')}}</label>
                    <select name="rating" class="form-select @error('rating') is-invalid @enderror" id="rating" style="width: 30%;">
                        <option selected>{{__('titles.review.select')}}</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    @error('rating')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            <div class="col-md-6">
                <button type="submit" class="float-end w-25 btn btn-primary bi bi-send"> {{__('titles.review.send')}}</button>
            </div>
        </div>

    </form>
</div>
