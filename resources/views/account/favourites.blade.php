@extends("layouts.account")
@section('title', __('account.favourites'))

@section('contents')
    <section class="banner-section">
        <div class="banner-part" style="background-image:url('{{ asset('/images/chris-karidis-QXW1YEMhq_4-unsplash.png')}}')"></div>
    </section>
    <section class="category-section">
        <div class="container">
            <div id="favourite-page">
                <div class="container">
                    <div class="d-flex flex-column flex-md-row partial-block">
                        @include('account.sidebar')
                        <section class="large">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                                <div class="title-part">
                                    <h1>{{__('account.favourites')}}</h1>
                                    <p>{{__('account.My next trip')}}</p>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($wishs as $wish)
                                    <div class="col-12 col-sm-6 col-lg-4 favourite-block" style="position:relative;">
                                        <i class="heart" onclick="removeFabvorite({{$wish->id}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="55" height="54.193" viewBox="0 0 55 54.193"><defs><filter id="a" x="0" y="0" width="55" height="54.193" filterUnits="userSpaceOnUse"><feOffset dy="4" input="SourceAlpha"/><feGaussianBlur stdDeviation="5" result="b"/><feFlood flood-opacity="0.161"/><feComposite operator="in" in2="b"/><feComposite in="SourceGraphic"/></filter></defs><g transform="matrix(1, 0, 0, 1, 0, 0)" filter="url(#a)"><path d="M20.913,3.938h-.058a6.564,6.564,0,0,0-5.481,3,6.564,6.564,0,0,0-5.481-3H9.837a6.523,6.523,0,0,0-6.462,6.519,14.043,14.043,0,0,0,2.758,7.656,48.327,48.327,0,0,0,9.242,8.9,48.327,48.327,0,0,0,9.242-8.9,14.043,14.043,0,0,0,2.758-7.656A6.523,6.523,0,0,0,20.913,3.938Z" transform="translate(12.13 7.56)" fill="rgba(236, 56, 89, 1)" stroke="#fff" stroke-width="1"/></g></svg>
                                        </i>
                                        <a href="{{route('accommodation.single', ['locale' => App::getLocale(), 'id' => $wish->accommodation_id, 'check_in' => \Carbon\Carbon::today()->format('m/d/Y'), 'check_out' => \Carbon\Carbon::tomorrow()->format('m/d/Y'), 'adults' => 2])}}" target="_blank">
                                            <figure>
                                               @php $firstImage = $wish->accommodations()->accommodationable->images->first(function($image) {
                                                    return $image->featured_image == 1 && $image->url;
                                                    });
                                                @endphp
                                            @if($firstImage)
                                                <img class="hover-img" src="{{ asset('storage/uploads/' . $firstImage->url) }}" alt="">
                                            @else
                                                <img class="hover-img" src="/images/hotel2.png" alt="">
                                            @endif
                                        </figure>
                                                <h3>{{$wish->accommodations()->title}}</h3>
                                        </a>
                                        <div class="star-block">
                                            <div class="stars">


                                                    @if($wish->accommodations()->hotel() &&  $wish->accommodations()->hotel()->in_stock == 1)
                                                    @for ($i = 0; $i < $wish->accommodations()->hotel()->stars_num; $i++)
                                                        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                                    @endfor
                                                    @for ($i = 0; $i < (5 - $wish->accommodations()->hotel()->stars_num); $i++)
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                                                    @endfor
                                                    @endif
                                                        @if($wish->accommodations()->hotel() &&  $wish->accommodations()->hotel()->in_stock !=1)
                                                            @for ($i = 0; $i < $wish->accommodations()->hotel()->stars_num; $i++)
                                                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"><path d="M11.143,8H1.857A1.857,1.857,0,0,0,0,9.857V21H11.143A1.857,1.857,0,0,0,13,19.143V9.857A1.857,1.857,0,0,0,11.143,8ZM6.5,17.286A2.786,2.786,0,1,1,9.286,14.5,2.786,2.786,0,0,1,6.5,17.286Z" transform="translate(0 -8)" fill="#faaf40"/></svg>
                                                            @endfor
                                                                @for ($i = 0; $i < (5 - $wish->accommodations()->hotel()->stars_num); $i++)
                                                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"><path d="M11.143,8H1.857A1.857,1.857,0,0,0,0,9.857V21H11.143A1.857,1.857,0,0,0,13,19.143V9.857A1.857,1.857,0,0,0,11.143,8ZM6.5,17.286A2.786,2.786,0,1,1,9.286,14.5,2.786,2.786,0,0,1,6.5,17.286Z" transform="translate(0 -8)" fill="#faaf40"/></svg>
                                                                @endfor
                                                        @endif
                                            </div>
                                        </div>
                                        <h4>{{$wish->accommodations()->city->name.", ".$wish->accommodations()->country->name}}</h4>
                                        <div class="price-box">
                                            <span class="price">{{number_format($wish->getPrice(), 0, '.', ' ')}} руб.</span>
                                        </div>
                                        <div class="rating-box">
                                            <span>Rating</span>


                                            </div>
                                        </div>
                            @endforeach
                            </div>
                            </section>
                            </div>
        </div>
        </div>
    </div>
</section>
@endsection
