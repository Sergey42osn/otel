<div id="sidebar-filter" class="accordion-outer-block sidebar-filter">
<h2>{{__('filter.filter_by')}}</h2>
{{--    <form action="{{ Request::getRequestUri() }}" method="get" id="filter-form" class="budget-form">--}}
    <form action="{{ route('search', ['locale' => App::getLocale()]) }}" method="get" id="filter-form" class="budget-form">
        <input type="hidden" name="place_id" value="{{request()->get('place_id')}}">
        <input type="hidden" name="place_type" value="{{request()->get('place_type')}}">
        <input type="hidden" name="place_name" value="{{request()->get('place_name')}}">
        <input type="hidden" name="sort" value="{{request()->get('sort')}}">
        <input type="hidden" name="check_in" value="{{request()->get('check_in')}}">
        <input type="hidden" name="check_out" value="{{request()->get('check_out')}}">
        <input type="hidden" name="rooms" value="{{request()->get('rooms')}}">
        <input type="hidden" name="adults" value="{{request()->get('adults')}}">
        <input type="hidden" name="children" value="{{request()->get('children')}}">

        <div>
            <h3 class="filter-inner-title">{{__('filter.your_budget_(per_night)')}}</h3>
            <div class="range-slider slider-container">
                <span class="output outputOne"></span>
                <span class="output outputTwo"></span>
                <span class="full-range"></span>
                <span class="incl-range"></span>
                <input name="rangeOne" value="{{ request()->all()['rangeOne'] ?? ($price_min ?? 0)}}" min="{{$price_min ?? 0}}" max="{{$price_max ? $price_max - $price_min - 100 : 300000}}" step="100" class="range" type="range">
                <input name="rangeTwo" value="{{ request()->all()['rangeTwo'] ?? ($price_max ?? 1000000)}}" min="{{$price_min ?? 0}}" max="{{$price_max ? $price_max - $price_min + 100 : 300000}}" step="100" class="range" type="range">
            </div>
            <button type="submit" class="range-btn">{{__('filter.apply')}}</button>
        </div>

        <div class="accordion" id="">
            <div class="accordion-item">
                <h3 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        {{__('filter.property_type')}}
                    </button>
                </h3>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input {{ !empty(request()->all()['accommodations']) && in_array('hotel', request()->all()["accommodations"]) ? "checked" : "" }} name="accommodations[]" type="checkbox" id="hotel" value="hotel" />
                                    <label for="hotel" class="checkBtn-label">{{__('filter.hotels')}}</label>
                                </div>
{{--                                <div class="type-number">{{$hotel_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <input {{ !empty(request()->all()['accommodations']) && in_array('apartment', request()->all()['accommodations']) ? "checked" : "" }} name="accommodations[]" type="checkbox" id="apartment" value="apartment"/>
                                    <label for="apartment" class="checkBtn-label">{{__('filter.apartments')}}</label>
                                </div>
{{--                                <div class="type-number">{{$apartment_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <input {{ !empty(request()->all()['accommodations']) && in_array('villa', request()->all()['accommodations']) ? "checked" : "" }} name="accommodations[]" type="checkbox" id="villa" value="villa"/>
                                    <label for="villa" class="checkBtn-label">{{__('filter.villas')}}</label>
                                </div>
{{--                                <div class="type-number">{{$villas_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <input {{ !empty(request()->all()['accommodations']) && in_array('youth-hotel', request()->all()["accommodations"]) ? "checked" : "" }} name="accommodations[]" type="checkbox" id="youth-hotel" value="youth-hotel"/>
                                    <label for="youth-hotel" class="checkBtn-label">{{__('filter.youth-hotel')}}</label>
                                </div>
{{--                                <div class="type-number">{{$youth_hotel_count ?? 0}}</div>--}}
                            </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="headingTwo">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        {{__('accommodation.star')}}
                    </button>
                </h3>
                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star[1]" {{ !empty(request()->all()['star']) && !empty(request()->all()["star"][1]) ? "checked" : "" }} value="1" type="checkbox" id="star-1"/>
                                    <label for="star-1" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$star_1_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star[2]" {{ !empty(request()->all()['star']) && !empty(request()->all()["star"][2]) ? "checked" : "" }} value="2" type="checkbox" id="star-2"/>
                                    <label for="star-2" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$star_2_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star[3]" {{ !empty(request()->all()['star']) && !empty(request()->all()["star"][3]) ? "checked" : "" }} value="3" type="checkbox" id="star-3"/>
                                    <label for="star-3" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$star_3_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input  name="star[4]" {{ !empty(request()->all()['star']) && !empty(request()->all()["star"][4]) ? "checked" : "" }} value="4" type="checkbox" id="star-4"/>
                                    <label for="star-4" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$star_4_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star[5]" {{ !empty(request()->all()['star']) && !empty(request()->all()["star"][5]) ? "checked" : "" }} value="5" type="checkbox" id="star-5"/>
                                    <label  for="star-5" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$star_5_count ?? 0}}</div>--}}
                            </div>

                    </div>
                </div>
            </div>
            @if(isset($amenities) && $amenities->count())
                <div class="accordion-item">
                    <h3 class="accordion-header" id="headingThree">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            {{__('filter.services')}}
                        </button>
                    </h3>
                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @foreach($amenities as $key => $amenity)
                                <div  class="{{$key > 4 ? "d-none amenities" :""}} d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" name="amenities[]" {{ !empty(request()->all()['amenities']) && in_array($amenity->id,request()->all()['amenities']) ? 'checked' : ""}} value="{{$amenity->id}}" id="self-service{{$key}}"/>
                                        <label for="self-service{{$key}}" class="checkBtn-label">{{json_decode($amenity->name, true)[App::getLocale()]}}</label>
                                    </div>
{{--                                    <div class="type-number">{{$amenity->count ?? 0}}</div>--}}
                                </div>
                            @endforeach
                            <button class="show-amenities amenities" type="button">{{(count($amenities) - 5) > 0 ? __("filter.show_all") ." ". (count($amenities) - 5) : ""}} </button>
                            <button class="show-amenities amenities d-none" type="button">{{(count($amenities) - 5) > 0 ? __("filter.hide") ." ". (count($amenities) - 5) : ""}}</button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="accordion-item">
                <h3 class="accordion-header" id="headingFour">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        {{__('filter.star_rating')}}
                    </button>
                </h3>
                <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star_rating[1]" {{ !empty(request()->all()['star_rating']) && !empty(request()->all()["star_rating"][1]) ? "checked" : "" }} value="1" type="checkbox" id="star-rating-1"/>
                                    <label for="star-rating-1" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$rating_star_1_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star_rating[2]" {{ !empty(request()->all()['star_rating']) && !empty(request()->all()["star_rating"][2]) ? "checked" : "" }} value="2" type="checkbox" id="star-rating-2"/>
                                    <label for="star-rating-2" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$rating_star_2_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star_rating[3]" {{ !empty(request()->all()['star_rating']) && !empty(request()->all()["star_rating"][3]) ? "checked" : "" }} value="3" type="checkbox" id="star-rating-3"/>
                                    <label for="star-rating-3" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$rating_star_3_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star_rating[4]" {{ !empty(request()->all()['star_rating']) && !empty(request()->all()["star_rating"][4]) ? "checked" : "" }} value="4" type="checkbox" id="star-rating-4"/>
                                    <label for="star-rating-4" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$rating_star_4_count ?? 0}}</div>--}}
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input name="star_rating[5]" {{ !empty(request()->all()['star_rating']) && !empty(request()->all()["star_rating"][5]) ? "checked" : "" }} value="5" type="checkbox" id="star-rating-5"/>
                                    <label for="star-rating-5" class="checkBtn-label">
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                    </label>
                                </div>
{{--                                <div class="type-number">{{$rating_star_5_count ?? 0}}</div>--}}
                            </div>

                    </div>
                </div>
            </div>
            @if (isset($services) && $services->count())
                <div class="accordion-item">
                    <h3 class="accordion-header" id="headingFive">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            {{__('filter.facilities')}}
                        </button>
                    </h3>
                    <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @foreach($services as $key => $service)
                                <div  class="{{$key > 4 ? "d-none services" :""}}  d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" name="services[]" {{ !empty(request()->all()['services']) && in_array($service->id,request()->all()['services']) ? 'checked' : ""}} value="{{$service->id}}" id="service{{$key}}"/>
                                        <label for="service{{$key}}" class="checkBtn-label">{{json_decode($service->name, true)[App::getLocale()]}}</label>
                                    </div>
{{--                                    <div class="type-number">{{$service->count ?? 0}}</div>--}}
                                </div>
                            @endforeach
                            <button class="show-services services" type="button">{{(count($services) - 5) > 0 ? __("filter.show_all") ." ". (count($services) - 5) : ""}}</button>
                            <button class="show-services services d-none" type="button">{{(count($services) - 5) > 0 ? __("filter.hide") ." ". (count($services) - 5) : ""}}</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>

