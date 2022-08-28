
<section class="reviews-section">
    <div class="title-part">
        <h2>@lang('accommodation.availability')</h2>
    </div>
    <div class="rating-block">
        <div class="rating-box">
            <span>{{$accommodation->ratingCount()}}/5</span>
        </div>
        <p>@lang('accommodation.rating')</p>
    </div>
    <div id="reviews-slider" class="owl-carousel">
        @foreach($accommodation->ratings as $rating)
            <div class="reviews-slider-item">
                <div class="d-flex reviews-slider-heading">
                    @if($rating->user->image)
                        <span><img src="{{asset('images/'.$rating->user->image->url ?? null)}}"></span>
                    @endif
                    <div>
                        <h3>{{$rating->user->name}}</h3>
                        <span>{{$rating->created_at}}</span>
                    </div>
                </div>
                <div class="stars">
                    @for ($i = 0; $i < $rating->rating; $i++)
                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                    @endfor
                    @for ($i = 0; $i < (5 - $rating->rating); $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                    @endfor

                </div>
                <div class="review-text">
                    <p>{{$rating->comment}}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
<section class="add-review-section">
    <div id="add-review">
        <div class="add-review-block">
            @guest
                <h2 data-bs-toggle="modal" data-bs-target="#loginModal">@lang('accommodation.addReview')</h2>
            @endguest
            @auth
                @if(Auth::user()->role_id != 1 && $can_review)
                    <input type="checkbox" checked>
                    <h2>@lang('accommodation.addReview')</h2>
                    <form class="open-review">
                        <h3>@lang('accommodation.rating')</h3>
                        <div class="star-box">
                            <input class="star" name="ratingStars" type="radio" id="star1" value="1">
                            <label for="star1">
                                <svg class="getStar" xmlns="http://www.w3.org/2000/svg" width="18.149" height="17.261" viewBox="0 0 18.149 17.261"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(1.074 -0.188)" fill="" stroke="#faaf40" stroke-width="1"/></svg>
                            </label>
                            <input class="star" name="ratingStars" type="radio" id="star2" value="2">
                            <label for="star2">
                                <svg class="getStar" xmlns="http://www.w3.org/2000/svg" width="18.149" height="17.261" viewBox="0 0 18.149 17.261"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(1.074 -0.188)" fill="" stroke="#faaf40" stroke-width="1"/></svg>
                            </label>
                            <input class="star" name="ratingStars" type="radio" id="star3" value="3">
                            <label for="star3">
                                <svg class="getStar" xmlns="http://www.w3.org/2000/svg" width="18.149" height="17.261" viewBox="0 0 18.149 17.261"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(1.074 -0.188)" fill="" stroke="#faaf40" stroke-width="1"/></svg>
                            </label>
                            <input class="star" name="ratingStars" type="radio" id="star4" value="4">
                            <label for="star4">
                                <svg class="getStar" xmlns="http://www.w3.org/2000/svg" width="18.149" height="17.261" viewBox="0 0 18.149 17.261"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(1.074 -0.188)" fill="" stroke="#faaf40" stroke-width="1"/></svg>
                            </label>
                            <input class="star" name="ratingStars" type="radio" id="star5" value="5">
                            <label for="star5">
                                <svg class="getStar" xmlns="http://www.w3.org/2000/svg" width="18.149" height="17.261" viewBox="0 0 18.149 17.261"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(1.074 -0.188)" fill="" stroke="#faaf40" stroke-width="1"/></svg>
                            </label>
                        </div>
                        <div>
                            <label for="">@lang('accommodation.description')</label>
                            <textarea name="description" id="ratingDescription" cols="30" rows="10" placeholder="@lang('accommodation.description')"></textarea>
                        </div>
                        <button id="addRating" type="button" class="btn btn-blue submit-btn">@lang('accommodation.add')</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</section>