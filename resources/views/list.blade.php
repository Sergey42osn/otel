@extends('layouts.default')
@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/ru.min.js" integrity="sha512-j5j9djiluSFyBwFHffI4b5CcyyyX02BSVBadb3ee8489Pl7Mj8uhsdbKNjeMDqaSx93iHty+rMchTZ0/3wVSBA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop
{{-- Page title --}}
@section('title')
    Dashboard @parent
@stop
@php $request_params = request()->all(); @endphp
{{-- page level styles --}}
@section('header_styles')
    <!-- page vendors -->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
    <!--end of page vendors -->
@stop
@section('content')
    <main id="product-feed">
        <section class="banner-section banner-user-section">
            <div class="banner-part" style="background-image:url('/images/chris-karidis-QXW1YEMhq_4-unsplash.png')"></div>
        </section>
        <div class="container">
            <section class="breadcrumb-block">
                <span>{{__("accommodation.homepage")}}</span>
                <span>{{__("accommodation.search_results")}}</span>
{{--                <span>{{__("homepage.accommodation")}}Tribeca Hotel</span>--}}
            </section>
        </div>
        <div id="product-inner-feed">
            <div class="container">
                <div class="row position-relative">
                    <div class="col-12 col-lg-4 col-xl-3">
                        @include('layouts.search')
                        @include('layouts.filter')
                    </div>
                    <div class="col-12 col-lg-8 col-xl-9">
                        <div class="title-part">
                            <h1>{{!empty(request()->all()['place_name']) && !empty(request()->all()['place_id']) ? request()->all()['place_name'].":" : "" }} {{$count ?? ''}} {{__("accommodation.properties_found")}}</h1>
                        </div>
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <button id="toggle-filters" type="button" class="btn btn-primary d-md-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21.5" height="21.5" viewBox="0 0 21.5 21.5"><g transform="translate(-3.25 -3.25)"><path d="M12.75,17.5H4" transform="translate(0 3.375)" fill="none" stroke="#111" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M21.25,18.125A3.125,3.125,0,1,1,18.125,15,3.125,3.125,0,0,1,21.25,18.125Z" transform="translate(2.75 2.75)" fill="none" stroke="#2576ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" fill-rule="evenodd"/><path d="M13,6.5h8.75" transform="translate(2.25 0.625)" fill="none" stroke="#111" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M4,7.125A3.125,3.125,0,1,0,7.125,4,3.124,3.124,0,0,0,4,7.125Z" fill="none" stroke="#2576ec" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" fill-rule="evenodd"/></g></svg>
                                <span>{{__('filter.filters')}}</span>
                            </button>
{{--                            @dd(request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'best_offer']));--}}
                            <a href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'best_offer'])}}" type="button" class="btn btn-primary d-none d-md-block{{ (isset($request_params['sort']) && $request_params['sort'] == 'best_offer') ? ' active' : '' }}">{{__("accommodation.best_offers")}}</a>
                            <a href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'price_high'])}}" type="button" class="btn btn-primary d-none d-md-block{{ (isset($request_params['sort']) && $request_params['sort'] == 'price_high') ? ' active' : '' }}">{{__("accommodation.price_lower_first")}}</a>
                            <a href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'stars_highest'])}}" type="button" class="btn btn-primary d-none d-md-block{{ (isset($request_params['sort']) && $request_params['sort'] == 'stars_highest') ? ' active' : '' }}">{{__("accommodation.stars_highest_first")}}</a>

                            <div class="btn-group filter-sort-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <span class="d-block d-md-none">{{__('filter.sort_by')}}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16"><g transform="translate(-1281 -24)"><rect width="22" height="2" rx="1" transform="translate(1281 24)" fill=""/><rect width="14" height="2" rx="1" transform="translate(1281 31)" fill=""/><rect width="4" height="2" rx="1" transform="translate(1299 31)" fill=""/><rect width="22" height="2" rx="1" transform="translate(1281 38)" fill=""/></g></svg>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li class="d-md-none">
                                        <a class="dropdown-item{{ (isset($request_params['sort']) && $request_params['sort'] == 'best_offer') ? ' active' : '' }}" href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'best_offer'])}}">{{__("accommodation.best_offers")}}</a>
                                    </li>
                                    <li class="d-md-none">
                                        <a class="dropdown-item{{ (isset($request_params['sort']) && $request_params['sort'] == 'price_high') ? ' active' : '' }}" href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'price_high'])}} ">{{__("accommodation.price_lower_first")}}</a>
                                    </li>
                                    <li class="d-md-none">
                                        <a class="dropdown-item{{ (isset($request_params['sort']) && $request_params['sort'] == 'stars_highest') ? ' active' : '' }}" href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'stars_highest'])}} ">{{__("accommodation.stars_highest_first")}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item{{ (isset($request_params['sort']) && $request_params['sort'] == 'price_lower') ? ' active' : '' }}" href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'price_lower'])}} ">{{__("accommodation.price_high_first")}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item{{ (isset($request_params['sort']) && $request_params['sort'] == 'stars_least') ? ' active' : '' }}" href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'stars_least'])}} ">{{__("accommodation.stars_least_first")}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item{{ (isset($request_params['sort']) && $request_params['sort'] == 'guest_rating') ? ' active' : '' }}" href="{{ request()->merge(['page' => 1])->fullUrlWithQuery(['sort' => 'guest_rating'])}} ">{{__("accommodation.guest_rating")}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="list-feed">
                            @if (isset($products) && $products->count())
                                @foreach($products as $product)
                                    <div class="d-flex flex-column flex-md-row p-3 each-product-block">
                                        <figure>
                                            @guest
                                                <div class="favorite" data-bs-toggle="modal" data-bs-target="#loginModal">
                                                    <img src="/images/{{ 'heart.png' }}" alt="heart" title="{{__('hotel.save')}}">
                                                </div>
                                            @endguest
                                            @auth
                                                @if(Auth::user()->role_id != 1)
                                                    <div class="favorite auth heart-box-container" data-acc="{{$product->id}}" data-id="{{ $favorites[$product->id] ?? 0 }}">
                                                        <img src="/images/{{ isset($favorites[$product->id]) ? 'heart-fill.png' : 'heart.png' }}" alt="heart" title="{{__('hotel.save')}}">
                                                    </div>
                                                @endif
                                            @endauth
                                            <a href="{{route('accommodation.single', array_merge(['locale' => app()->getLocale(), 'id' => $product->id], $request_params))}}">
                                                <img src="/storage/uploads/{{$product->featured_image()->url ?? "" }}" alt="hotel-image">
                                            </a>
                                        </figure>
                                        <div class="d-flex flex-column each-product-description-block">
                                            <h2><a href="{{route('accommodation.single', array_merge(['locale' => app()->getLocale(), 'id' => $product->id], $request_params))}}">{{$product->title}}</a></h2>
                                            <div class="d-flex align-items-center stars">
                                            @if(!empty($product->accommodationable->stars_num))
                                                @if($product->accommodationable->in_stock)
                                                    @for($i = 1; $i <= $product->accommodationable->stars_num; $i++)
                                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                                    @endfor
                                                @else
                                                    @for($i = 1; $i <= $product->accommodationable->stars_num; $i++)
                                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"><path d="M11.143,8H1.857A1.857,1.857,0,0,0,0,9.857V21H11.143A1.857,1.857,0,0,0,13,19.143V9.857A1.857,1.857,0,0,0,11.143,8ZM6.5,17.286A2.786,2.786,0,1,1,9.286,14.5,2.786,2.786,0,0,1,6.5,17.286Z" transform="translate(0 -8)" fill="#faaf40"/></svg>
                                                    @endfor
                                                @endif
                                            @endif
                                            </div>
                                                @if(!empty($product->description))
                                                <p class="product-description">
                                                    {{isset(str_split($product->description, 250)[1])?str_split($product->description, 250)[0]."...":$product->description}}
                                                </p>
                                            @endif
                                            @if($product->city)
                                                <div class="hotel-location">
                                                    <p>{{$product->city->name}} {{$product->country->name}}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-between each-product-price-block">
                                            <div class="d-flex flex-row flex-md-column justify-content-between align-items-md-end price-review-block">
                                                <div class="d-flex justify-content-between flex-md-column align-items-md-end">
                                                    <div class="d-flex flex-column align-items-md-end">
                                                        <div class="d-flex flex-column align-items-md-center flex-md-row rate-block">
                                                            <span>{{__("accommodation.rating")}}</span>
                                                            <span class="rating">{{$product->ratings_number()}}/5</span>
                                                        </div>
                                                        <span class="review-quantity">{{ $product->ratings ? count($product->ratings) : $product->id}} {{__("accommodation.reviews")}}</span>
                                                    </div>
                                                </div>
                                                <span class="d-flex align-items-end price">
                                                {{number_format($prices[$product->chanelObject->accommodation_crm_code], 0, '.', ' ') ?? ""}} {{__('filter.rub')}}
                                            </span>
                                            </div>
                                            <a href="{{route('accommodation.single', array_merge(['locale' => app()->getLocale(), 'id' => $product->id], $request_params))}}" class="btn btn-blue">{{__('filter.more')}}</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if (isset($res))
                                @foreach($res as $row)
                                    <div class="d-flex flex-column flex-md-row p-3 each-product-block">
                                        <figure>
                                            @guest
                                                <div class="favorite" data-bs-toggle="modal" data-bs-target="#loginModal">
                                                    <img src="/images/{{ 'heart.png' }}" alt="heart" title="{{__('hotel.save')}}">
                                                </div>
                                            @endguest
                                            @auth
                                                @if(Auth::user()->role_id != 1)
                                                    <div class="favorite auth heart-box-container" data-acc="{{$product->id}}" data-id="{{ $favorites[$product->id] ?? 0 }}">
                                                        <img src="/images/{{ isset($favorites[$product->id]) ? 'heart-fill.png' : 'heart.png' }}" alt="heart" title="{{__('hotel.save')}}">
                                                    </div>
                                                @endif
                                            @endauth
                                            <a href="{{route('single', array_merge(['locale' => app()->getLocale(), 'slug' => $row['slug']], $request_params))}}">
                                                <img src="{{ $row['images'] }}" alt="hotel-image">
                                            </a>
                                        </figure>
                                        <div class="d-flex flex-column each-product-description-block">
                                            <h2><a href="{{route('single', array_merge(['locale' => app()->getLocale(), 'slug' => $row['slug']], $request_params))}}">{{ $row['name'] }}</a></h2>
                                            <div class="d-flex align-items-center stars">
                                                @if(!empty($row['star_rating']))
                                                    @if($row['star_rating'])
                                                        @for($i = 1; $i <= $row['star_rating']; $i++)
                                                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                                        @endfor
                                                    @else
                                                        @for($i = 1; $i <= $row['star_rating']; $i++)
                                                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"><path d="M11.143,8H1.857A1.857,1.857,0,0,0,0,9.857V21H11.143A1.857,1.857,0,0,0,13,19.143V9.857A1.857,1.857,0,0,0,11.143,8ZM6.5,17.286A2.786,2.786,0,1,1,9.286,14.5,2.786,2.786,0,0,1,6.5,17.286Z" transform="translate(0 -8)" fill="#faaf40"/></svg>
                                                        @endfor
                                                    @endif
                                                @endif
                                            </div>
                                                <p class="product-description">
                                                   {{isset(str_split($row['description'] , 250)[1])?str_split($row['description'] , 250)[0]."...":$row['description'] }}
                                                </p>
                                                <div class="hotel-location">
                                                    <p>{{$row['region']['city']}} {{$row['region']['location']}}</p>
                                                </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-between each-product-price-block">
                                            <div class="d-flex flex-row flex-md-column justify-content-between align-items-md-end price-review-block">
                                                <div class="d-flex justify-content-between flex-md-column align-items-md-end">
                                                    <div class="d-flex flex-column align-items-md-end">
                                                        <div class="d-flex flex-column align-items-md-center flex-md-row rate-block">
                                                            <span>12345</span>
                                                            <span class="rating">3/5</span>
                                                        </div>
                                                        <span class="review-quantity">1</span>
                                                    </div>
                                                </div>
                                                <span class="d-flex align-items-end price">
                                                    {{$row["daily_prices"] ? $row["daily_prices"][0] : ''}}
                                            </span>
                                            </div>
                                            <a href="{{route('single', array_merge(['locale' => app()->getLocale(), 'slug' => $row['slug']], $request_params))}}" class="btn btn-blue">{{__('filter.more')}}</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- start repeated part -->
                            <!-- end repeated part -->
                        </div>
                        @if (isset($products) && $products->count())
                            <div class="pagination">
                                {{ $products->links('pagination') }}
                                <!-- <nav>
                                    <a href="" class="arrow disabled">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9.148" height="16" viewBox="0 0 12.579 22"><path d="M15.038,17.192l8.325-8.319a1.566,1.566,0,0,0,0-2.22,1.585,1.585,0,0,0-2.227,0L11.7,16.079a1.569,1.569,0,0,0-.046,2.168l9.471,9.491a1.572,1.572,0,1,0,2.227-2.22Z" transform="translate(-11.246 -6.196)" fill="#2576ec" /></svg>
                                    </a>
                                    <ul>
                                        <li class="active">
                                            <a href="">1</a>
                                        </li>
                                        <li>
                                            <a href="">2</a>
                                        </li>
                                        <li>
                                            <a href="">3</a>
                                        </li>
                                    </ul>
                                    <a href=""  class="arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9.148" height="16" viewBox="0 0 9.148 16"><path d="M14.19,17.637l6.05-6.055a1.139,1.139,0,0,1,1.615,0,1.153,1.153,0,0,1,0,1.62L15,20.062a1.141,1.141,0,0,1-1.577.033l-6.9-6.888a1.144,1.144,0,0,1,1.615-1.62Z" transform="translate(-11.246 22.188) rotate(-90)" fill="#2576ec"/></svg>
                                    </a>
                                </nav>
                                <p>Showing 1-25</p> -->
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop

@section('footer_scripts')
    <!--   page level js ----------->
    <script language="javascript" type="text/javascript" src="{{ asset('vendors/chartjs/js/Chart.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="/pages/filter.js"></script>
    <!-- end of page level js -->
@stop
