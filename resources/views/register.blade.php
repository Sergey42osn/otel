@extends("layouts.vendor")

@section('contents')
    <section class="banner-section">
        <div class="banner-part" style="background-image:url('{{ asset("images/chris-karidis-QXW1YEMhq_4-unsplash.png")}}')"></div>
    </section>
    <section class="category-section">
        <div class="container">
            <div class="title-part">
                <h1>{{ __('hotel.title')}}</h1>
            </div>
            <div class="category-block d-flex">
                <div class="category-item">
                    <figure>
                        <img src="{{ asset('images/image-pool.png')}}" alt="hotel">
                        <figcaption>{{ __('hotel.hotel')}}</figcaption>
                    </figure>
                    <a class="btn-blue" href="{{route('hotels.create', ['locale' => app()->getLocale()])}}">{{ __('hotel.register_property')}}</a>
                </div>
                <div class="category-item">
                    <figure>
                        <img src="{{ asset('images/image-building.png')}}" alt="appartment">
                        <figcaption>{{ __('hotel.appartment')}}</figcaption>
                    </figure>
                    <a class="btn-blue" href="{{route('appartments.create', ['locale' => app()->getLocale()])}}">{{ __('hotel.register_property')}}</a>
                </div>
                <div class="category-item">
                    <figure>
                        <img src="{{ asset('images/image-villa.png')}}" alt="appartment">
                        <figcaption>{{ __('hotel.villa')}}</figcaption>
                    </figure>
                    <a class="btn-blue" href="{{route('villas.create', ['locale' => app()->getLocale()])}}">{{ __('hotel.register_property')}}</a>
                </div>
                <div class="category-item">
                    <figure>
                        <img src="{{ asset('images/image-home.png')}}" alt="appartment">
                        <figcaption>{{ __('hotel.youth')}}</figcaption>
                    </figure>
                    <a class="btn-blue" href="{{route('youth-hotels.create', ['locale' => app()->getLocale()])}}">{{ __('hotel.register_property')}}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
