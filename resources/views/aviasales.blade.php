@extends("layouts.app")
@section('contents')
    <main id="legal-info-page">
    <section class="banner-section">
			<div class="banner-part" style="background-image:url('/images/chris-karidis-QXW1YEMhq_4-unsplash.png')"></div>
		</section>
        <div class="container">
            <nav class="breadcrumb-block" aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home_page',App::getLocale())  }}">{{__("page.legal.homepage")}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Aviasales</li>
                </ul>
            </nav>
        </div>
        @if(\App::getLocale()=='ru')
            <div class="min-container">
                <p>НЕ ТОЛЬКО ОТЕЛИ</p>
                <p>Друзья, наша мечта – сделать ваше путешествие максимально комфортным и удобным.</p>
                <p>
                    Поэтому на нашем сайте у вас есть возможность не только забронировать самые лучшие отели и апартаменты, а также купить билеты в любую точку мира.
                </p>
                <p>
                    Данный сервис предлагает наш Партнёр – Aviasales, крупнейший поисковик авиабилетов в России. По окончании бронирования вам придёт ссылка, по которой вы сможете найти самые лучшие предложения от мировых авиакомпаний.
                </p>
                <p>
                    Поиск дешёвых авиабилетов, календарь низких цен и не только.
                </p>
                <p>
                    Бронируй на ruking.ru
                </p>
                <p>Летай с Aviasales.</p> <br> <br>
                <span style="padding-right: 300px;padding-top: 20px;">АДРЕС ССЫЛКИ</span>
                <p class="mt-2">
                    <a href="https://aviasales.tp.st/KEecZH7c" target="_blank">https://aviasales.tp.st/KEecZH7c</a>
                </p>
            </div>
        @else
            <div class="min-container">
                <p>NOT ONLY HOTELS</p>
                <p>Dear friends, our dream is to make your trip as comfortable and convenient as possible.</p>
                <p>
                    Therefore, on our website you can book the best hotels and apartments as well as to buy tickets to anywhere in the world.
                </p>
                <p>
                    This service is offered by our Partner – Aviasales, the largest flight search engine in Russia. At the end of the booking, you will receive a link where you can find the best deals from the world's airlines.
                </p>

                <p>
                    Cheap flights search engine, a calendar of low prices and more.
                </p>
                <p>
                    Book now on ruking.ru
                </p>
                <p>Fly with Aviasales.</p> <br><br>
                <span style="padding-right: 300px;padding-top: 20px;">LINK ADDRESS</span>
                <p class="mt-2">
                    <a href="https://aviasales.tp.st/KEecZH7c" target="_blank" >https://aviasales.tp.st/KEecZH7c</a>
                </p>
            </div>
        @endif
    </main>
@endsection
