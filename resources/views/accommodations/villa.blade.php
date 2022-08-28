<main id="single-villa-product-page" class="single-product-page">
    @if($accommodation->banner_image)
        <section class="banner-section">
            <div class="banner-part" style="background-image:url({{asset('images/' . $accommodation->banner_image)}})"></div>
        </section>
    @endif
        <div class="container">
        <section class="breadcrumb-block">
            <a href="/">@lang('accommodation.homepage')</a>
            <span>{{$accommodation->title}}</span>
        </section>
        <section class="single-hotel-section">
            <div class="row flex-row-reverse">
                <div class="col-12 col-lg-9">
                    <div class="hotel-description flex-column flex-md-row">
                        <div class="hotel-name-star">
                            <h1>{{$accommodation->title}}</h1>
                        </div>
                        <!-- justify-content-end -->
                        <div class="d-flex flex-row-reverse single-button-group flex-md-row align-items-center">
                            <input type="hidden" value="{{Auth::id()}}" class="auth">
                            <input type="hidden" value="{{$accommodation->id}}" class="accommodation">
                            <input type="hidden" value="{{$accommodation->wishList->id ?? null}}" class="wish-list">

                            @guest
                                <span class="heart-box icon-box" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26 25.309">
                                            <path id="Icon_ionic-ios-heart" data-name="Icon ionic-ios-heart" d="M20.913,3.938h-.058a6.564,6.564,0,0,0-5.481,3,6.564,6.564,0,0,0-5.481-3H9.837a6.523,6.523,0,0,0-6.462,6.519,14.043,14.043,0,0,0,2.758,7.656,48.327,48.327,0,0,0,9.242,8.9,48.327,48.327,0,0,0,9.242-8.9,14.043,14.043,0,0,0,2.758-7.656A6.523,6.523,0,0,0,20.913,3.938Z" transform="translate(-2.375 -2.938)" fill="" stroke="#2576ec" stroke-width="2"/>
                                        </svg>
                                    </span>
                            @endguest
                            @auth
                                @if( Auth::user()->role_id != 1 )
                                    <span class="heart-box auth icon-box">
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
                                <div class="dropdown-menu share-dropdown">
                                    <ul class="share-menu">
                                        <li class="">
                                            <a onclick="share.vk()">
                                                <i><img src="/images/vcontact-icon.png" alt="icon"></i>
                                                <span>Поделиться через Вконтакте</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="https://connect.ok.ru/offer?url={{URL::full()}}&title=Ruking{{ $accommodation->featured_image() ? '&imageUrl=' . url('/') . '/storage/uploads/' . $accommodation->featured_image()->url : ''}}">
                                                <i><img src="/images/odnoclassniki-icon.png" alt="icon"></i>
                                                <span>Поделиться через Одноклассники</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a onclick="share.clip()">
                                                <i><img src="/images/copy-icon.png" alt="icon"></i>
                                                <span>Скопировать ссылку</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if(Auth::check())
                                <a href="#availability-section">
                                    <button class="btn-blue">@lang('accommodation.book')</button>
                                </a>
                            @else
                                <a href="#availability-section">
                                    <button class="btn-blue">@lang('accommodation.book')</button>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="hotel-location">
                        @if($accommodation->address)
                            <p>{{$accommodation->address->zip_code.' '.$accommodation->address->street_house}}</p>
                        @endif
                    </div>
                    @include('accommodations.slider', [compact('accommodation'), 'type' => 'villa'])
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
                        <p>{{$accommodation->description}}</p>
                    </div>
                    <p class="language-text">@lang('accommodation.staffLang')
                        @foreach($accommodation->langs as $key => $lang)
                            @if($key == 0)
                                {{$lang->name}}
                            @else
                                {{', ' . $lang->name}}
                            @endif
                        @endforeach
                    </p>
                </div>
                <div class="col-12 col-md-4 facilities-block">
                    <div class="facilities-list-block">
                        <h3>@lang('accommodation.facilities')</h3>
                        <ul>
                            @foreach($accommodation->services as $service)
                                <li class="list-item">
                                    @if($service->icon)
                                        <i>
                                            <img src="/images/{{$service->icon}}" alt="">
                                        </i>
                                    @endif
                                    <span>{{$service->name}}</span>
                                </li>
                            @endforeach
                            @foreach($accommodation->amenities as $amenity)
                                <li class="list-item">
                                    @if($amenity->icon)
                                        <i>
                                            <img src="/images/{{$amenity->icon}}" alt="">
                                        </i>
                                    @endif
                                    <span>{{$amenity->name}}</span>
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

            @include('accommodations.date_picker', $data=['id' => 2])

            <div class="abailability-table">
                <div class="d-md-flex d-none">
                    <div class="available-table-heading table-column">
                        <span>@lang('accommodation.roomType')</span>
                    </div>
                    <div class="available-table-heading table-column">
                        <span>@lang('accommodation.priceFor') <nights id="setNights">{{$days}} {{trans_choice('accommodation.nights', $days)}}</nights></span>
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
                    @php $not_empty = is_array($rooms) ? !empty($rooms) : $rooms->isNotEmpty(); @endphp
                    @if($not_empty)
                        @foreach($rooms as $room)
                            @include('accommodations.room', compact('room', 'accommodation'))
                        @endforeach
                    @else
                        <p class="not-found ms-2 mt-2">@lang('rooms.not_found')</p>
                    @endif
                </div>
            </div>
        </section>
        @include('accommodations.review', compact('accommodation'))
        @include('accommodations.policies', compact('accommodation'))
    </div>
    @include('accommodations.subscription')
    <span id="check-in-init" name="check-in-init" class="visibility: hidden" value="{{ __('accommodation.checkIn') }}"></span>
    <span id="check-out-init" name="check-out-init" class="visibility: hidden" value="{{ __('accommodation.checkOut') }}"></span>
</main>
