<section class="banner-section">
    <main id="single-youthHotel-product-page" class="single-product-page">
        @if(isset($accommodation->banner_image))
        <section class="banner-section">
            <div class="banner-part" style="background-image:url({{asset('images/' . $accommodation->banner_image)}})"></div>
        </section>
        @endif
        <div class="container">
            <section class="breadcrumb-block">
                <a href="/">@lang('accommodation.homepage')</a>
                <span>{{$info_hotel_search['info']->name}}</span>
            </section>
            <section class="single-hotel-section">
                <div class="row flex-row-reverse">
                    <div class="col-12 col-lg-9">
                        <div class="hotel-description flex-column flex-md-row ">
                            <div class="hotel-name-star">
                                <h1>{{$info_hotel_search['info']->name}}</h1>
                            </div>
                            <div class="d-flex flex-row-reverse justify-content-md-end flex-md-row justify-content-between align-items-center">
                                <input type="hidden" value="{{Auth::id()}}" class="auth">
                                <input type="hidden" value="{{$info_hotel_search['info']->id}}" class="accommodation">
                               <!-- <input type="hidden" value="{{isset($accommodation->wishList) && Auth::check() && Auth::user()->id==isset($accommodation->wishList->user_id) && $accommodation->wishList?$accommodation->wishList->id : null}}" class="wish-list">-->

                                @guest
                                    <span class="heart-box icon-box" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26 25.309" style="fill: var(--white);">
                                            <path id="Icon_ionic-ios-heart" data-name="Icon ionic-ios-heart" d="M20.913,3.938h-.058a6.564,6.564,0,0,0-5.481,3,6.564,6.564,0,0,0-5.481-3H9.837a6.523,6.523,0,0,0-6.462,6.519,14.043,14.043,0,0,0,2.758,7.656,48.327,48.327,0,0,0,9.242,8.9,48.327,48.327,0,0,0,9.242-8.9,14.043,14.043,0,0,0,2.758-7.656A6.523,6.523,0,0,0,20.913,3.938Z" transform="translate(-2.375 -2.938)" fill="" stroke="#2576ec" stroke-width="2"/>
                                        </svg>
                                    </span>
                                @endguest
                                @auth
                                    @if( Auth::user()->role_id==2)
                                        <span class="heart-box auth icon-box">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26 25.309">
                                                <path id="Icon_ionic-ios-heart" data-name="Icon ionic-ios-heart" d="M20.913,3.938h-.058a6.564,6.564,0,0,0-5.481,3,6.564,6.564,0,0,0-5.481-3H9.837a6.523,6.523,0,0,0-6.462,6.519,14.043,14.043,0,0,0,2.758,7.656,48.327,48.327,0,0,0,9.242,8.9,48.327,48.327,0,0,0,9.242-8.9,14.043,14.043,0,0,0,2.758-7.656A6.523,6.523,0,0,0,20.913,3.938Z" transform="translate(-2.375 -2.938)" fill="" stroke="#2576ec" stroke-width="2"/>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="heart-box  icon-box" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26 25.309">
                                                <path id="Icon_ionic-ios-heart" data-name="Icon ionic-ios-heart" d="M20.913,3.938h-.058a6.564,6.564,0,0,0-5.481,3,6.564,6.564,0,0,0-5.481-3H9.837a6.523,6.523,0,0,0-6.462,6.519,14.043,14.043,0,0,0,2.758,7.656,48.327,48.327,0,0,0,9.242,8.9,48.327,48.327,0,0,0,9.242-8.9,14.043,14.043,0,0,0,2.758-7.656A6.523,6.523,0,0,0,20.913,3.938Z" transform="translate(-2.375 -2.938)" fill="" stroke="#2576ec" stroke-width="2"/>
                                            </svg>
                                        </span>
                                    @endif
                                @endauth
                                <div class="position-relative">
                                    <button class="share-box icon-box dropdown-toggle"  data-bs-toggle="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 21.736 24">
                                            <path id="Icon_ionic-md-share" data-name="Icon ionic-md-share" d="M22.6,20.1a3.3,3.3,0,0,0-2.362.9l-8.658-5a4.055,4.055,0,0,0,.121-.844,4.053,4.053,0,0,0-.121-.844l8.537-4.944A3.623,3.623,0,1,0,18.97,6.712a4.031,4.031,0,0,0,.121.844L10.555,12.5a3.644,3.644,0,0,0-2.482-.965A3.585,3.585,0,0,0,4.5,15.154a3.645,3.645,0,0,0,6.115,2.653l8.6,5a3.025,3.025,0,0,0-.121.784A3.512,3.512,0,1,0,22.6,20.1Z" transform="translate(-4.5 -3.094)" fill="#2576ec"/>
                                        </svg>
                                    </button>
                                </div>
                                <a href="#availability-section">
                                    <button class="btn-blue">@lang('accommodation.book')</button>
                                </a>
                            </div>
                        </div>
                         <div class="stars">
                             @if(!empty($info_hotel->star_rating))
                                 @if($info_hotel->star_rating)
                                     @for($i = 1; $i <= $info_hotel->star_rating; $i++)
                                         <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                     @endfor
                                 @else
                                     @for($i = 1; $i <= $info_hotel->star_rating; $i++)
                                         <svg class="active" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"><path d="M11.143,8H1.857A1.857,1.857,0,0,0,0,9.857V21H11.143A1.857,1.857,0,0,0,13,19.143V9.857A1.857,1.857,0,0,0,11.143,8ZM6.5,17.286A2.786,2.786,0,1,1,9.286,14.5,2.786,2.786,0,0,1,6.5,17.286Z" transform="translate(0 -8)" fill="#faaf40"/></svg>
                                     @endfor
                                 @endif
                             @endif
                        </div>
                        <div class="hotel-location">
                            @if($info_hotel_search['info']->address)
                                <p>{{$info_hotel_search['info']->region->country_code . ' ' . $info_hotel_search['info']->region->name . ' ' .$info_hotel_search['info']->postal_code.' '.$info_hotel_search['info']->address}}</p>
                            @endif
                        </div>
                        @include('apisingle.slider', [compact('info_hotel_search'), 'type' => 'hotel'])
                    </div>
                    <div class="col-12 col-lg-3">
                        @include('layouts.search')
                        <div class="map-block">
                            <div id="mymap" style="width: 100%; height: 100%"></div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="facilities-section">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-8">
                        <div class="text-box">
                            @if($info_hotel_search['info']->description_struct)
                                @foreach($info_hotel_search['info']->description_struct as $desc)
                                    @foreach($desc->paragraphs as $d)
                                        <p>{{$d}}</p>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-4 facilities-block">
                        <div class="facilities-list-block">
                            <h3>@lang('accommodation.facilities')</h3>
                            <ul>
                                @foreach($info_hotel_search['info']->facts->electricity as $elect)
                                    <li class="list-item">
                                    </li>
                                @endforeach
                                <li class="list-item">
                        
                                        <span>{{$info_hotel_search['info']->facts->electricity->voltage[0]}}</span>
                                    </li>
                                @foreach($info_hotel_search['info']->amenity_groups[0]->amenities as $amenit)
                                    <li class="list-item">
                                        <span>{{$amenit}}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class="availability-section" id="availability-section">
                <div class="title-part">
                    <h2>@lang('accommodation.availability')</h2>
                </div>

                @include('apisingle.date_picker', [compact('info_hotel_search'), 'type' => 'hotel'])
                <div class="abailability-table">
                    <div class="d-md-flex d-none">
                        <div class="available-table-heading table-column">
                            <span>@lang('accommodation.roomType')</span>
                        </div>
                        <div class="available-table-heading table-column">
                            <span>@lang('accommodation.priceFor') <nights id="setNights">{{ $info['night_count']}} {{trans_choice('accommodation.nights', $info['night_count'])}}</nights></span>
                        </div>
                        <div class="available-table-heading table-column">
                            <span>@lang('accommodation.services')</span>
                        </div>
                        <div class="available-table-heading table-column">
                            <span>@lang('accommodation.pleaseChoose')</span>
                        </div>
                        <div class="available-table-heading table-column">

                        </div>
                    </div>
                    <div id="rooms-list">
                        @if($info_hotel_search['res'])
                            @foreach($info_hotel_search['res'][0]->rates as $k_r => $room)
                                    @php
                                        $room_images = $rooms_images[$room->room_data_trans->main_name];
                                    @endphp
                                    @include('apisingle.room', compact('room','room_images','k_r','info'))
                            @endforeach
                        @else
                            <p class="not-found ms-2 mt-2">@lang('rooms.not_found')</p>
                        @endif
                    </div>
                </div>
            </section>
           <!-- @//include('apisingle.review', compact('accommodation'))-->
            @include('apisingle.policies', compact('info_hotel_search'))
        </div>
            @include('accommodations.subscription')
        <span id="check-in-init" name="check-in-init" class="visibility: hidden" value="{{ __('accommodation.checkIn') }}"></span>
        <span id="check-out-init" name="check-out-init" class="visibility: hidden" value="{{ __('accommodation.checkOut') }}"></span>
    </main>
</section>
