@extends("layouts.app")

@php
    $weekDayNames = [
                __('accommodation.su'),
                __('accommodation.mo'),
                __('accommodation.tu'),
                __('accommodation.we'),
                __('accommodation.th'),
                __('accommodation.fr'),
                __('accommodation.sa'),
            ];
    $check_in = \Carbon\Carbon::today();
    $check_out = \Carbon\Carbon::tomorrow();
    $check_in_day_num = $check_in->dayOfWeek;
    $check_out_day_num = $check_out->dayOfWeek;
    $check_in_day = $check_in->day;
    $check_out_day = $check_out->day;
    $check_in_month = $check_in->monthName;
    $check_out_month = $check_out->monthName;
    $check_in_year = $check_in->year;
    $check_out_year = $check_out->year;
    $check_in_date = $weekDayNames[$check_in_day_num].', '.$check_in_day.' '.$check_in_month;
    $check_out_date = $weekDayNames[$check_out_day_num].', '.$check_out_day.' '.$check_out_month;
@endphp

@section('contents')
    <div class="hidden-appLocale">{{\App::getLocale()}}</div>
    <div class="container">
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show text-center mt-5" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <main id="home-page">
        <section class="banner-section">
            <div class="container">
                <div class="home-title-part">
                    <h1>{{__("home.find_the_accommodation_that's_right_for_you")}}</h1>
                    <form action="{{route('search', [App::getLocale()])}}" id="search-form" class="d-flex justify-content-between">
                        <div class="place-input-box">
                            <input type="text" name="place_name" id="place_name" placeholder="{{__('home.where_are_you_going?')}}" autocomplete="off">
                            <div class="validation-text">
                                <p>чтобы начать поиск введите направление</p>
                            </div>
                            <input value="" name="place_id" id="place_id" type="hidden">
                            <input value="" name="place_type" id="place_type" type="hidden">

                            <div id="placersContainer" style="position: sticky; margin-top: 3.5px;"></div>
                            <!-- style="margin-top: 110px; width: 373px;" -->
                        </div>
                        <div id="calendar-input-box" class="calendar-input-box">
                            <input type="text" value="{{\Carbon\Carbon::today()->format('d/m/Y')}}-{{\Carbon\Carbon::tomorrow()->format('d/m/Y')}}" class="datefilter home-filter" data-id="1" readonly/>
                            <input type="hidden"  name="check_in" value="{{\Carbon\Carbon::today()->format('m/d/Y')}}"  id="check_in" class="check_in_hidden">
                            <input type="hidden"  name="check_out" value="{{\Carbon\Carbon::tomorrow()->format('m/d/Y')}}"  id="check_out" class="check_out_hidden">
                            <div>
                                <span id="check-in" class="check_in" data-id="1">{{$check_in_date}}</span>
                            </div>
                            <div>
                                <span id="check-out" class="check_out" data-id="1">{{$check_out_date}}</span>
                            </div>
                            <i class="chev"></i>
                        </div>

{{--                        <input type="hidden" id="login_modal_st" value="{{$open_login_modal}}"/>--}}

                        <div class="people-input-box">
                            <div class="coll">
{{--                                <details id="selectorBoxContainer" class="selectorBox" data-id="1">--}}
{{--                                1 @lang('accommodation.room') - --}}
                                    <input class="selectorBox" data-id="1" data-status="closed" type="text" name="" value="2 @lang('accommodation.adult')" readonly/>
                                    <input type="hidden" data-id="1" class="hiddenRoomCount" name="rooms" value="1">
                                    <input type="hidden" data-id="1" class="hiddenAdultCount" name="adults" value="2">
                                    <input type="hidden" data-id="1" class="hiddenChildCount" name="children" value="0">
{{--                                    <summary id="selectorBox" data-status="closed">--}}
{{--                                        <p>--}}
{{--                                            {{request()->all()['rooms'] ?? 1 }} {{trans_choice('filter.rooms',request()->all()['rooms'] ?? 1)}} ---}}
{{--                                            {{request()->all()['adults'] ?? 1 }} {{trans_choice('filter.adult', request()->all()['adults'] ?? 1 )}} ---}}
{{--                                            {{request()->all()['children'] ?? '' }} {{trans_choice('filter.child', request()->all()['children'] ?? 1 )}}--}}
{{--                                        </p>--}}
{{--                                        <i class="chev"></i>--}}
{{--                                    </summary>--}}

{{--                                </details>--}}
                                <div id="selectorBoxArea" data-id="1" class="selectorBoxArea people-input-box-opening-block">
                                    <div class="person-row d-flex justify-content-between d-none">
                                        <p class="person-input-title">@lang('accommodation.room')</p>
                                        <div class="d-flex align-items-center minus-plus-box">
                                            <button type="button" class="minus roomMinus">
                                                <minus>-</minus>
                                            </button>
                                            <span class="roomCount">1</span>
                                            <button type="button" class="plus roomPlus">
                                                <span>+</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="person-row d-flex justify-content-between">
                                        <p class="person-input-title">@lang('accommodation.adult')</p>
                                        <div class="d-flex align-items-center minus-plus-box">
                                            <button type="button" class="minus adultMinus">
                                                <minus>-</minus>
                                            </button>
                                            <span class="adultCount">2</span>
                                            <button type="button" class="plus adultPlus">
                                                <span>+</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="person-row d-flex justify-content-between">
                                        <p class="person-input-title">@lang('accommodation.child')</p>
                                        <div class="d-flex align-items-center minus-plus-box">
                                            <button class="minus childMinus" type="button">
                                                <minus>-</minus>
                                            </button>
                                            <span class="childCount">0</span>
                                            <button class="plus childPlus" type="button">
                                                <span>+</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="person-row flex-wrap child-ages d-flex justify-content-between">
                                    </div>
                                </div>
                                <div class="animate">

                                    <div id="selectorBoxArea" class="people-input-box-opening-block">
                                        <div class="person-row d-flex justify-content-between">
                                            <p class="person-input-title">{{__("home.room")}}</p>
                                            <div class="d-flex align-items-center minus-plus-box">
                                                <button id="roomMinus" class="minus" type="button">
                                                    <span></span>
                                                </button>
                                                <span id="roomCount">1</span>
                                                <button id="roomPlus" class="plus" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g transform="translate(-747 -1896.75)"><rect width="16" height="1.5" transform="translate(747 1904)" fill="#2475eb"></rect><rect width="16" height="1.5" transform="translate(755.75 1896.75) rotate(90)" fill="#2475eb"></rect></g></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="person-row d-flex justify-content-between">
                                            <p class="person-input-title">{{__("home.adult")}}</p>
                                            <div class="d-flex align-items-center minus-plus-box">
                                                <button id="adultMinus" class="minus" type="button">
                                                    <span></span>
                                                </button>
                                                <span id="adultCount">1</span>
                                                <button id="adultPlus" class="plus" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g transform="translate(-747 -1896.75)"><rect width="16" height="1.5" transform="translate(747 1904)" fill="#2475eb"></rect><rect width="16" height="1.5" transform="translate(755.75 1896.75) rotate(90)" fill="#2475eb"></rect></g></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="person-row d-flex justify-content-between">
                                            <p class="person-input-title">{{__("home.child")}}</p>
                                            <div class="d-flex align-items-center minus-plus-box">
                                                <button id="childMinus" class="minus" type="button">
                                                    <span></span>
                                                </button>
                                                <span id="childCount">0</span>
                                                <button id="childPlus" class="plus" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g transform="translate(-747 -1896.75)"><rect width="16" height="1.5" transform="translate(747 1904)" fill="#2475eb"></rect><rect width="16" height="1.5" transform="translate(755.75 1896.75) rotate(90)" fill="#2475eb"></rect></g></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="search-btn search-btn-box">
                            <button>
                                <span>{{__("home.search")}}</span>
                                <img src="images/Icon feather-search.png" alt="">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <figure class="banner-background-image">
                <img src="images/chris-karidis-QXW1YEMhq_4-unsplash.png" alt="">
            </figure>
        </section>
        <div>
            <div class="container">
                <div class="title-part">
                    <h2 class="main-title">{{__("home.our_partners")}}</h2>
                </div>
                <section class="best-offer-section">
                    <div class="row best-offer-block">
                        <div class="col-12 col-md-4">
                            <div class="ya-taxi-widget" data-use-location="false" data-app="3" data-redirect="1178268795219780156" data-tariff="econom" data-lang="ru" data-size="m" data-picture="http://ruking.production.am/images/yandex.jpg" data-theme="normal" data-title="Вызвать такси" data-point-a="" data-point-b="" data-ref="2659891" data-proxy-url="https://{app}.redirect.appmetrica.yandex.com/route?start-lat={start-lat}&amp;start-lon={start-lon}&amp;end-lat={end-lat}&amp;end-lon={end-lon}&amp;ref={ref}&amp;appmetrica_tracking_id={redirect}&amp;tariffClass={tariff}&amp;lang={lang}"></div>
                            <script src="//yastatic.net/taxi-widget/ya-taxi-widget.js"></script>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="{{ route('aviasales',['locale' => \App::getLocale()]) }}" target="blank">
                                <figure>
                                    <img src="images/aviasales.png" alt="best-offer-icon">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="https://tp.media/click?shmarker=371690&promo_id=4070&source_type=link&type=click&campaign_id=135&trs=178033" target="blank">
                                <figure>
                                    <img src="images/poezd_ru.png" alt="best-offer-icon">
                                </figure>
                            </a>
                        </div>
                    </div>
                </section>
                <section class="best-tour-city-section">
                    <div class="row owl-carousel" id="best-tour-city-section">
                    @foreach($places as $i=>$place)
                        @php
                            $place_hotels = $place->accommodations->filter(function($accommodation) {
                                return $accommodation->type == 'hotel';
                            });
                            $place_apartments = $place->accommodations->filter(function($accommodation) {
                                return $accommodation->type == 'apartment';
                            });
                            $place_villas = $place->accommodations->filter(function($accommodation) {
                                return $accommodation->type == 'villa';
                            });
                            $place_yout_hotels = $place->accommodations->filter(function($accommodation) {
                                return $accommodation->type == 'youth_hotel';
                            });
                        @endphp
                            <div class="col-12 col-md-{{ $i == 3 || $i == 4 ? '6' : '4'}} best-tour-city-box">
                                <a href="{{ route('search', [App::getLocale(),'place_type' => 'city', 'place_name' => $place->name, 'place_id' => $place->id])  }}">
                                    <figure>
                                        <figcaption>
                                            <h3>{{ $place->name }}</h3>
                                            <h4>{{ count($place_hotels) }} {{__('home.hotels')}} {{ count($place_apartments) }} {{__('home.apartments')}} {{ count($place_villas) }} {{__('home.villas')}} {{ count($place_yout_hotels) }} {{__('home.youth_hotel')}}</h4>
                                        </figcaption>
                                        <img class="hover-img" src="{{ $place_images[$place->id] }}" alt="">
                                    </figure>
                                </a>
                            </div>
                    @endforeach
                    </div>
                </section>
                <section class="property-type-search-section">
                    <div class="title-part">
                        <h2 class="main-title">{{__("home.search_by_property_type")}}</h2>
                    </div>
                    <div class="row property-type-block">
                        <div class="col-12 col-md-3">
                            <a href="{{ route('search', [App::getLocale(), 'accommodations' => ['hotel']])}}">
                                <figure>
                                    <figcaption>
                                        <h3>{{__("home.hotels")}}</h3>
                                    </figcaption>
                                    <img class="hover-img" src="/storage/uploads/hotel_img.png" alt="hotel_img">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ route('search', [App::getLocale(), 'accommodations' => ['apartment']])}}">
                                <figure>
                                    <figcaption>
                                        <h3>{{__("home.apartments")}}</h3>
                                    </figcaption>
                                    <img class="hover-img" src="/storage/uploads/app_img.png" alt="app_img">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ route('search', [App::getLocale(), 'accommodations' => ['villa']])}}">
                                <figure>
                                    <figcaption>
                                        <h3>{{__("home.villas")}}</h3>
                                    </figcaption>
                                    <img class="hover-img" src="/storage/uploads/villa_img.png" alt="villa_img">
                                </figure>
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <a href="{{ route('search', [App::getLocale(), 'accommodations' => ['youth-hotel']])}}">
                                <figure>
                                    <figcaption>
                                        <h3>{{__("home.youth_hotel")}}</h3>
                                    </figcaption>
                                    <img class="hover-img" src="/storage/uploads/youth_img.png" alt="youth_img">
                                </figure>
                            </a>
                        </div>
                    </div>
                </section>
                <section class="popular-type-search-section">
                    <div class="title-part">
                        <h2 class="main-title">{{__("home.popular_hotels_around_the_world")}}</h2>
                    </div>
                    <div class="owl-carousel" id="popular-type-block">
                        @forelse($hotels as $i => $hotel)
                            <div class="hotel-item hotel-item-selector">

                                <a href="{{route('accommodation.single', [
                                        'locale' => App::getLocale(),
                                        'id' => $hotel->id,
                                        'place_id' => $hotel->city->id,
                                        'place_name' => $hotel->city->name,
                                        'place_type' => 'city',
                                        'check_in' => \Carbon\Carbon::today()->format('m/d/Y'),
                                        'check_out' => \Carbon\Carbon::tomorrow()->format('m/d/Y')
                                     ])}}">
                                    <figure>
                                        <img class="hover-img" src="{{ asset('storage/uploads/' . $hotel->featured_image()?->url)  }}" alt="">
                                    </figure>
                                    <h3>{{ $hotel->title }}</h3>
                                </a>
                                @guest
                                    <div class="favorite" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        <img src="images/{{ isset($favorites[$hotel->id]) ? 'heart-fill.png' : 'heart.png' }}" alt="heart">
                                    </div>
                                @endguest
                                @auth
                                    @if(Auth::user()->role_id == 2)
                                        <div class="favorite auth heart-box-container" data-acc="{{ $hotel->id }}" data-id="{{ $favorites[$hotel->id] ?? 0 }}">
                                            <img src="images/{{ isset($favorites[$hotel->id]) ? 'heart-fill.png' : 'heart.png' }}" alt="heart">
                                        </div>
                                    @endif
                                @endauth
                                @if(!empty($hotel->hotel()->stars_num))
                                    @if($hotel->hotel()->in_stock)
                                        @for($i = 1; $i <= $hotel->hotel()->stars_num; $i++)
                                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                        @endfor
                                    @else
                                        @for($i = 1; $i <= $hotel->hotel()->stars_num; $i++)
                                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"><path d="M11.143,8H1.857A1.857,1.857,0,0,0,0,9.857V21H11.143A1.857,1.857,0,0,0,13,19.143V9.857A1.857,1.857,0,0,0,11.143,8ZM6.5,17.286A2.786,2.786,0,1,1,9.286,14.5,2.786,2.786,0,0,1,6.5,17.286Z" transform="translate(0 -8)" fill="#faaf40"/></svg>
                                        @endfor
                                    @endif
                                @endif
                                <h4>{{ $hotel->city->name }}, {{ $hotel->country->name }}</h4>
                                <div class="price-box">
{{--                                    <span class="price">{{ number_format($hotel->price, 0, '.', ' ')  }}</span><span> {{__('rooms.currency')}}</span>--}}
                                </div>
                                @if($hotel->avg_rating)
                                    <div class="rating-box">
                                        <span>{{__("home.rating")}}</span>
                                        <span>{{$hotel->avg_rating}}</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                        @endforelse
                    </div>
                </section>
{{--                <section class="suggestion-part">--}}
{{--                    <div class="title-part">--}}
{{--                        <h2 class="main-title">{{__("home.where_do_you_want_to_go?")}}</h2>--}}
{{--                    </div>--}}
{{--                    <div class="suggest-block">--}}
{{--                        <a href="">--}}
{{--                            <div class="suggest-inner-block">--}}
{{--								<span>--}}
{{--									<img src="{{ asset('images/star-tick.png')  }}" alt="star">--}}
{{--								</span>--}}
{{--                                <h2>{{__("home.where_to_go")}}</h2>--}}
{{--                                <h3>{{__("home.take_the_test_and_get_ideas_for_travel")}}</h3>--}}
{{--                            </div>--}}
{{--                            <a href="">--}}
{{--                                <figure>--}}
{{--                                    <img src="{{ asset('images/banner-img.png')  }}" alt="" class="hover-img">--}}
{{--                                </figure>--}}
{{--                            </a>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </section>--}}
                <section class="blog-section">
                    <div class="title-part">
                        <h2 class="main-title">{{__("home.be_inspired")}}</h2>
                    </div>
                    <div class="blog-block row owl-carousel" id="blog-block">
                        @foreach($blogs as $blog)
                        <div class="blog-block-item col-12 col-md-4">
                                <a href="{{route('blog.show', [App::getLocale(),'post'=>$blog, 'category' => $blog->categories->first()->slug ,'slug' => $blog->slug ])}}">
                                    <figure>
                                        <img class="hover-img" src="/storage/uploads/{{$blog->mainImage()}}" alt="blog-img">
                                    </figure>
                                </a>
                                <a href="{{route('blog.show', [App::getLocale(),'post'=>$blog, 'category' => $blog->categories->first()->slug ,'slug' => $blog->slug ])}}">
                                    <h3>{{$blog["title"]}}</h3>
                                </a>
                                <p>{{$blog["preview_text"]}}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
            @include('accommodations.subscription')
        </div>
        <span id="check-in-init" class="visibility: hidden" value="Check in"></span>
        <span id="check-out-init" class="visibility: hidden" value="Check out"></span>
    </main>
@endsection

@section('scripts')

    <script type="text/javascript">
        let datePickerButtons = {!! json_encode(['apply' => __('home.apply'), 'clear' => __('home.clear')]) !!}
    </script>

{{--    <script src="{{ asset('/js/singlePages/single.js')}}"></script>--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>




    <script type="text/javascript">

        let roomCountVar = 1;
        let adultCountVar = 2;
        let childCountVar = 0;
        let checkInDate = moment();
        let checkOutDate = moment().add(1,'days');

        let datePickerLocale = {
            cancelLabel: '',
            applyLabel: '{{__("home.apply")}}',
            format: 'MM/DD/YYYY',
            "daysOfWeek": [
                "{{__('accommodation.su')}}",
                "{{__('accommodation.mo')}}",
                "{{__('accommodation.tu')}}",
                "{{__('accommodation.we')}}",
                "{{__('accommodation.th')}}",
                "{{__('accommodation.fr')}}",
                "{{__('accommodation.sa')}}",
            ],
            "monthNames": [
                "{{__('accommodation.january')}}",
                "{{__('accommodation.february')}}",
                "{{__('accommodation.march')}}",
                "{{__('accommodation.april')}}",
                "{{__('accommodation.may')}}",
                "{{__('accommodation.june')}}",
                "{{__('accommodation.july')}}",
                "{{__('accommodation.august')}}",
                "{{__('accommodation.september')}}",
                "{{__('accommodation.october')}}",
                "{{__('accommodation.november')}}",
                "{{__('accommodation.december')}}",
            ],
            "firstDay": 1
        }

        $( document ).ready(function() {

            function updateSelectorBox(id,val){
                $('#' + id).html(val)
                $('#selectorBox').children('p').html(roomCount + " Room - "+ adultCount +" Adult - "+ childCount +" Child")
                $("#hiddenRoomCount").val(roomCount)
                $("#hiddenAdultCount").val(adultCount)
                $("#hiddenChildCount").val(childCount)
            }


            // async search result DOM element
            function placeRow(place){
                let typeClass = place.type ? 'object' : 'location';
                return `
                    <div style="cursor: pointer" data-name='${place.name[lang]}' data-id=${place.id} data-type= ${place.type ? "object" : (place.country ? "city" : "country")} class="placeRow ${typeClass}">
                        <span>${place.name[lang]}</span>
                        ${place.country? `<span style="font-weight: normal">${place.country.name[lang]}</span>` : ""}
                        ${place.city? `<span style="font-weight: normal">, ${place.city.name[lang]}</span>` : ""}
                    </div>
                `
            }
            // push async search results to dropdown
            $('#place_name').on('input',function (e){
                $('[name=place_id]').siblings('.validation-text').hide()
                let name = $(this).val();
                if(name.length > 2) {
                    $("#placersContainer").html("")
                    $.ajax({
                        url: "/api/filter-locations",
                        method: 'post',
                        data: {name : name},
                        success: function (data) {
                            $('#placersContainer').show()
                            $("#placersContainer").html("")

                            $.each(data.data,function (index,val){
                                let row = placeRow(val)
                                $("#placersContainer").append(row)
                            })
                        }
                    })
                }
            })

        });

    </script>
    <script src="/pages/filter.js"></script>
    <script src="/blog/js/script.js"></script>
    <script src="/js/datepicker.js"></script>
@stop
