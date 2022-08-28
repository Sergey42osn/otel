<!DOCTYPE html>
<html>

<head>
    <title>Ruking</title>
    <meta charset="utf-8">
    <meta name="description" content="Ruking">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link rel="shortcut icon" href="images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicon/favicon-144x144.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('images/favicon/favicon-64x64.png')}}">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/style-icon.css">
    <link rel="stylesheet" href="https://use.typekit.net/ctj8kld.css">
    <link rel="stylesheet" type="text/css" href="/css/vendor-employees.css">
    <script src="https://api-maps.yandex.ru/2.1/?lang=en_RU&amp;apikey=98976ac2-1627-4fc8-ac83-e4d35764b12c" type="text/javascript"></script>
    <script src="event_reverse_geocode.js" type="text/javascript"></script>
    <!-- <script src="https://api-maps.yandex.ru/2.1/?apikey=98976ac2-1627-4fc8-ac83-e4d35764b12c API-ключ&lang=ru_RU" type="text/javascript"> -->
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- <script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A053bd947d462cc1a45aeba4070defff75501905071c0eaf68436ac9976ec698c&amp;id=mymap&amp;lang=ru_RU&amp;apikey=<API-ключ>"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    @yield('styles')
    <style>
        .active {
            color: var(--orange);
        }

    </style>
</head>

<body>
    @include('layouts.header')
    <main>
        @yield('contents')
    </main>
    @include('layouts.footer')


    <script src="{{ asset('/js/jquery.min.js')}}"></script>
    <script src="{{ asset('/js/pages/register-vendor.js')}}"></script>
    @yield('scripts')

</body>

</html>
