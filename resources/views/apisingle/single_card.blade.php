@extends('layouts.vendor')


@section("styles")
<link href="{{ asset('css/singlePages/single.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<x-yandex-map :coords="46.347626,48.029451" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
<script src="{{ asset('js/single/singleapi.js')}}"></script>


<!-- sliders -->
<style>
    * {
        box-sizing: border-box
    }
    body {
        font-family: Verdana,
        sans-serif; margin:0
    }
    .mySlides {
        display: none
    }
    img {
        vertical-align: middle;
    }
    .mySlides img {
        width: 100%;
        height: 450px;
        border-radius: 10px;
    }
    .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
        margin-top: 5%;
    }

    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 30%;
        width: 50px;
        height:50px;
        padding: 15px;
        margin-top: -20px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        user-select: none;
    }
    .zoom {
        cursor: pointer;
        position: absolute;
        top: 60%;
        width: 50px;
        height:50px;
        margin-top: -20px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        right: 10px;
    }
    #prev-button, #next-button {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: 50px;
        height:50px;
        padding: 15px;
        margin-top: -20px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        user-select: none;
        pointer-events: auto;

    }

    #prev-button img, #next-button img{
        filter: brightness(25);
    }

    .next{
        right: 10px;
    }
    .prev{
        left: 10px;
    }
    #prev-button{
        left: -5%;
    }
    #next-button{
        right: -5%;
    }
    .prev:hover, .next:hover {
        background-color: rgba(255,255,255,0.9);
    }

    .text {
        color: #f2f2f2;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 8px;
        width: 100%;
        text-align: center;
    }

    .numbertext {
        color: #f2f2f2;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
    }

    .dot {
        cursor: pointer;
        height: 150px;
        margin-left: 10px;
        width: 230px;
        object-fit: cover;
        border-radius: 10px;
        transition: background-color 0.6s ease;
        margin-top:10px
    }
    .gallery__lightbox {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 20000;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.9s;
    }

    .gallery__lightbox-content {
        width: 80%;
        height: 80%;
        position: relative;
    }

    .close {
        top: -25px;
        right: -2%;
        /* background-color: #1473e6; */
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        color: #fff;
        width: 30px;
        height: 30px;
        position: absolute;
        text-decoration: none;
        font-size: 20px;
        display: flex;
        justify-content: center;
        border-radius: 50%;
        z-index:9999;
        pointer-events: auto;
        filter: invert(1);
    }

    .gallery__lightbox-image {
        border-radius: 4px;
        width: 100%;
        height: 100%;
    }

    .gallery__lightbox:target {
        opacity: 1;
        pointer-events: auto;
    }

    .fade {
        animation-name: fade;
        animation-duration: 1.5s;
    }
    .button {
        background-color: rgba(255,255,255,0.9);
        border-radius:50%;
        color:#1473e6;
        text-align: center;
    }
    #main-div
    {
        width: auto;
        height: 200px;
        overflow: hidden;
    }
    #main-div ul
    {
        list-style: none;
        margin: 0;
        padding: 0;
        min-width: 1500px;
        position: relative;
        left: 0;
    }

    #main-div li
    {
        height: 200px;
        display: inline-block;
    }

    @keyframes fade {
        from {opacity: .4}
        to {opacity: 1}
    }
    @media only screen and (max-width: 768px) {
        .dot {
            width: 150px;
        }
        #main-div ul {
            width: 1300px
        }
        .gallery__lightbox-image {
            width: 90%;
            margin-left: 5%;
        }
        .close {
            right: 1%
        }
    }
    .image-zoom {
        height: auto!important;
        width: -webkit-fill-available;
    }

</style>

@endsection

@section('contents')



    <!-- date picker deps -->
{{--    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js" charset="utf-8"></script>

    <div class="hidden-appLocale">{{\App::getLocale()}}</div>
    <div class="hidden-accommodation">{{$info_hotel_search['info']->id}}</div>
        @switch($info_hotel_search['info']->kind == 'Hotel')
            @case('hotel')
                @include("apisingle.hotel")
            @break

            @case('apartment')
                @include("accommodations.appartment")
            @break

            @case('villa')
                @include("accommodations.villa")
            @break

            @case('youth_hotel')
                @include("accommodations.youthHotel")
            @break

        @endswitch

@endsection


@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('/js/pages/filter.js')}}"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
