<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <title>
        @yield('title')
    </title>
    <meta charset="utf-8">
    <meta name="description" content="Ruking">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link rel="shortcut icon" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/favicon-144x144.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="64x64" href="images/favicon/favicon-64x64.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://use.typekit.net/ctj8kld.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css">
{{--    <script src="https://code.jquery.com/auth-link-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous">
    </script>
    <script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A053bd947d462cc1a45aeba4070defff75501905071c0eaf68436ac9976ec698c&amp;id=mymap&amp;lang=ru_RU&amp;apikey=<API-????????>"></script>

    @yield('styles')
</head>

<body>
@include('layouts.header')
<main id="@yield('main_id')">
    @yield('contents')
</main>
@guest()
    <!-- Customer login Modal -->
    @include('auth.customer.customer-login')
    <!-- Customer registration Modal -->
    @include('auth.vendor.vendor-confirm_email')

    @include('auth.vendor.vendor-confirm_phone')
    <!-- Customer registration Modal -->
    @include('auth.customer.customer-registration')
    <!-- Vendor registration modal -->
    @include('auth.vendor.vendor-registration')
    <!-- Customer Confirm Modal -->
    @include('auth.customer.customer-confirm')
    <!-- Customer Confirm phone Modal -->
    @include('auth.customer.customer-phone-confirm')
    <!-- Vendor Confirm Modal -->
    @include('auth.vendor.vendor-confirm')
@endguest

@include('layouts.footer')
@include('auth.vendor.vendor-login')
{{--<script src="{{ asset('/js/jquery.min.js')}}"></script>--}}
@yield('scripts')

<script src="{{ asset('js/home.js') }}"></script>
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>

    $('.auth-link').click(function(e) {
        e.preventDefault();
        var modal = $(this).data('modal');
        $(modal).modal("toggle")
    })

</script>

@guest()
    <script src="{{asset('js/pages/register.js')}}"></script>
@endguest

</body>

</html>
