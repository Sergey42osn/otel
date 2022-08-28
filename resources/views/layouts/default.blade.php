<!DOCTYPE html>
<html lang="{{App::getLocale()}}">

<head>
    <title>Ruking</title>
    <meta charset="utf-8">
    <meta name="description" content="Ruking">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/favicon-144x144.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="64x64" href="/images/favicon/favicon-64x64.png">
    <link rel="stylesheet" href="https://use.typekit.net/ctj8kld.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" />
    <link rel="stylesheet" href="{{asset('fonts/iconmind.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- global css -->

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
    <style>
        #demo {
            position: relative;

            overflow: auto;
        }
    </style>
    <!-- end of global css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .irs--round .irs-bar {
        background-color: #00C2C0;
    }

    .irs--round .irs-handle {
        background-color: #00C2C0;
        border-color: #00C2C0;
        box-shadow: 0px 0px 0px 5px rgba(0, 194, 192, 0.2);
    }

    .irs--round .irs-handle.state_hover,
    .irs--round .irs-handle:hover {
        background-color: #00C2C0;
    }

    .irs--round .irs-handle {
        width: 16px;
        height: 16px;
        top: 29px
    }

    .irs--round .irs-from,
    .irs--round .irs-to,
    .irs--round .irs-single {
        background-color: transparent;
        color: #666666;
    }

    .irs--round .irs-from:before,
    .irs--round .irs-to:before,
    .irs--round .irs-single:before,
    .irs--round .irs-min,
    .irs--round .irs-max {
        display: none;
    }


</style>
    <!-- vendors  css -->
    @yield('header_styles')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>    <script src="{{ asset('js/custom.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/ru.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
@guest()
    <!-- Customer login Modal -->
    @include('auth.customer.customer-login')
    <!-- Customer registration Modal -->
    @include('auth.customer.customer-registration')

    @include('auth.vendor.vendor-confirm_email')

    @include('auth.vendor.vendor-confirm_phone')
    <!-- Vendor registration modal -->
    @include('auth.vendor.vendor-login')
    <!-- Vendor registration modal -->
    @include('auth.vendor.vendor-registration')
    <!-- Confirm Modal -->
    @include('auth.vendor.vendor-confirm')
@endguest
<body>

    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')


    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-53569782-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-53569782-1');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous">
    </script>

    @yield('footer_scripts')
    <script src="/js/pages/filter.js"></script>
    <script src="{{ asset('js/datepicker.js') }}"></script>
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
