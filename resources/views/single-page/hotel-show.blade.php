@extends('layouts.vendor')
@section("styles")
<link href="{{ asset('css/singlePages/single.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css">

</script>
<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A053bd947d462cc1a45aeba4070defff75501905071c0eaf68436ac9976ec698c&amp;id=mymap&amp;lang=ru_RU&amp;apikey=<API-ключ>"></script>

@endsection
@section('contents')

<section class="banner-section">
    <main id="single-youthHotel-product-page" class="single-product-page">
        <section class="banner-section">
            <div class="banner-part" style="background-image:url({{asset('images/chris-karidis-QXW1YEMhq_4-unsplash.png')}})"></div>
        </section>
        <div class="container">
            <section class="breadcrumb-block">
                <span>Homepage</span>
                <span> Search results</span>
                <span>Tribeca Hotel</span>
            </section>
            <section class="single-hotel-section">
                <div class="row flex-row-reverse">
                    <div class="col-12 col-md-7 col-lg-9">
                        <div class="hotel-description flex-column flex-md-row">
                            <div class="hotel-name-star">
                                <h1>{{$hotel->accommodation->title}}</h1>
                            </div>
                            <div class="d-flex flex-row-reverse justify-content-end flex-md-row">
                                <span class="heart-box icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 26 25.309">
                                        <path id="Icon_ionic-ios-heart" data-name="Icon ionic-ios-heart" d="M20.913,3.938h-.058a6.564,6.564,0,0,0-5.481,3,6.564,6.564,0,0,0-5.481-3H9.837a6.523,6.523,0,0,0-6.462,6.519,14.043,14.043,0,0,0,2.758,7.656,48.327,48.327,0,0,0,9.242,8.9,48.327,48.327,0,0,0,9.242-8.9,14.043,14.043,0,0,0,2.758-7.656A6.523,6.523,0,0,0,20.913,3.938Z" transform="translate(-2.375 -2.938)" fill="none" stroke="#2576ec" stroke-width="2"/>
                                      </svg>
                                </span>
                                <span class="share-box icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 21.736 24">
                                        <path id="Icon_ionic-md-share" data-name="Icon ionic-md-share" d="M22.6,20.1a3.3,3.3,0,0,0-2.362.9l-8.658-5a4.055,4.055,0,0,0,.121-.844,4.053,4.053,0,0,0-.121-.844l8.537-4.944A3.623,3.623,0,1,0,18.97,6.712a4.031,4.031,0,0,0,.121.844L10.555,12.5a3.644,3.644,0,0,0-2.482-.965A3.585,3.585,0,0,0,4.5,15.154a3.645,3.645,0,0,0,6.115,2.653l8.6,5a3.025,3.025,0,0,0-.121.784A3.512,3.512,0,1,0,22.6,20.1Z" transform="translate(-4.5 -3.094)" fill="#2576ec"/>
                                      </svg>
                                </span>
                                <button class="btn-blue">book</button>
                            </div>
                        </div>
                        <div class="hotel-location">
                            @if($hotel->accommodation->address)
                            <p>{{$hotel->accommodation->address->zip_code.' '.$hotel->accommodation->address->street_house}}</p>
                            @endif
                        </div>
                        <div>
                            <div class="main-image-div">
                                <figure>
                                    <img src="{{asset('images/346776891.png')}}" alt="">
                                </figure>
                            </div>
                            <div class="d-md-flex secondary-image-div d-none">
                                <figure>
                                    <img src="{{asset('images/224818546.png')}}" alt="">
                                </figure>
                                <figure>
                                    <img src="{{asset('images/224818546.png')}}" alt="">
                                </figure>
                                <figure>
                                    <img src="{{asset('images/224818546.png')}}" alt="">
                                </figure>
                                <figure>
                                    <img src="{{asset('images/224818546.png')}}" alt="">
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-3">
                        <form action="" class="single-search-form">
                            <h2>Search</h2>
                            <div class="place-input-box">
                                <label for="">place</label>
                                <input type="text">
                            </div>
                            <div class="single-calendar-input-box">
                                <div>
                                    <label for="">check in</label>
                                    <input type="text"  name="myDate1" value="" readonly id="datepicker1">
                                </div>
                                <div>
                                    <label for="">check out</label>
                                    <input type="text"  name="myDate2" value="" readonly id="datepicker2">
                                </div>
                            </div>
                            <div>
                                <label for="">rooms</label>
                                <div class="people-input-box">
                                    <input type="text">
                                </div>
                            </div>
                            <button class="btn-blue">Search</button>
                        </form>
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
                            <p>{{$hotel->accommodation->description}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 facilities-block">
                        <div class="facilities-list-block">
                            <h3>facilities</h3>
                            <ul>
                                <li class="wifi-item list-item">Free Wi-Fi</li>
                                <li class="transfer-item list-item">Airport transfer</li>
                                <li class="parking-item list-item">Free parking</li>
                                <li class="family-item list-item">Family room</li>
                                <li class="non-smoking-item list-item">Non-smoking rooms</li>
                                <li class="restaurant-item list-item">Restaurant</li>
                                <li class="bar-item list-item">Bar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class="availability-section">
                <div class="title-part">
                    <h2>Availability</h2>
                </div>
                <div class="availabilty-block">
                    <form class="d-flex justify-content-between flex-column flex-md-row">
                        <div class="calendar-input-box">
                            <input type="text" name="datefilter" value="" readonly/>
                            <div>
                                <span>Check in</span>
                            </div>
                            <div>
                                <span>Check out</span>
                            </div>
                        </div>
                        <div class="people-input-box">
                            <input type="text" name="" value="0 Room - 0 Adults - 0 Child" readonly/>
                        </div>
                        <div>
                            <button class="btn-blue">Check availability</button>
                        </div>
                    </form>
                </div>
                <div class="abailability-table">
                    <div class="d-md-flex d-none">
                        <div class="available-table-heading table-column">
                            <span>Room type</span>
                        </div>
                        <div class="available-table-heading table-column">
                            <span>Price for 4 nights</span>
                        </div>
                        <div class="available-table-heading table-column">
                            <span>Food</span>
                        </div>
                        <div class="available-table-heading table-column">
                            <span>Please choose</span>
                        </div>
                        <div class="available-table-heading table-column">

                        </div>
                    </div>
                    <div class="d-flex table-body flex-column flex-md-row">
                        <div class="table-column">
                            <div class="d-flex">
                                <figure>
                                    <img src="{{asset('images/tanya-semenchuk-0u0kKxfpvQ0-unsplash.png')}}" alt="">
                                </figure>
                                <h3>Double Room with 1 bed</h3>
                            </div>
                            <div class="table-text-box">
                                <h4>1 large double bed</h4>
                                <p>Air-conditioned room with a fridge, electric kettle and flat-screen TV. It has a private bathroom with bathrobes, slippers, a hairdryer and free toiletries.</p>
                                <ul>
                                    <li class="wifi-item list-item">Free Wi-Fi</li>
                                    <li class="transfer-item list-item">Airport transfer</li>
                                    <li class="parking-item list-item">Free parking</li>
                                </ul>
                            </div>
                        </div>
                        <div class="table-column">
                            <span class="d-block d-md-none">Price for 4 nights</span>
                            <span class="price">23328 Rub</span>
                        </div>
                        <div class="table-column">
                            <span class="d-block d-md-none">Food</span>
                            <span class="includedService">Breakfast included</span>
                        </div>
                        <div class="table-column">
                            <span class="d-block d-md-none">Please choose</span>
                            <select name="" id="">
                                <option value="">0</option>
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4</option>
                            </select>
                        </div>
                        <div class="table-column">
                            <button class="btn-blue">Book Now</button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="reviews-section">
                <div class="title-part">
                    <h2>Availability</h2>
                </div>
                <div class="rating-block">
                    <div class="rating-box">
                        <span>4.5/5</span>
                    </div>
                    <p>Ratingfffffffffffffff</p>
                </div>
                <div id="reviews-slider" class="owl-carousel">
                    <div class="reviews-slider-item">
                        <div class="d-flex reviews-slider-heading">
                            <span>E</span>
                            <div>
                                <h3>Evgenii</h3>
                                <span>03/22/2022 03:16</span>
                            </div>
                        </div>
                        <div class="stars">
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                        </div>
                        <div class="review-text">
                            <p>“Good location, clean rooms, excellent cleaning (even folded things), updated water, soap, etc.
                                pleased with the terrace overlooking the avenue. shops and cafes nearby. 2 km to the old town.”</p>
                        </div>
                    </div>
                    <div class="reviews-slider-item">
                        <div class="d-flex reviews-slider-heading">
                            <span>E</span>
                            <div>
                                <h3>Evgenii</h3>
                                <span>03/22/2022 03:16</span>
                            </div>
                        </div>
                        <div class="stars">
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                        </div>
                        <div class="review-text">
                            <p>“Good location, clean rooms, excellent cleaning (even folded things), updated water, soap, etc.
                                pleased with the terrace overlooking the avenue. shops and cafes nearby. 2 km to the old town.”</p>
                        </div>
                    </div>
                    <div class="reviews-slider-item">
                        <div class="d-flex reviews-slider-heading">
                            <span>E</span>
                            <div>
                                <h3>Evgenii</h3>
                                <span>03/22/2022 03:16</span>
                            </div>
                        </div>
                        <div class="stars">
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" width="16" height="15.217" viewBox="0 0 16 15.217"><path d="M8,1.318l2.472,5.009,5.528.8-4,3.9.944,5.506L8,13.936l-4.944,2.6L4,11.029l-4-3.9,5.528-.8Z" transform="translate(0 -1.318)" fill="#faaf40"/></svg>
                        </div>
                        <div class="review-text">
                            <p>“Good location, clean rooms, excellent cleaning (even folded things), updated water, soap, etc.
                                pleased with the terrace overlooking the avenue. shops and cafes nearby. 2 km to the old town.”</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="conditions-section">
                <div class="title-part">
                    <h2>Accommodation conditions</h2>
                </div>
                <div class="condition-box-body">
                    <div class="condition-box-row flex-column flex-md-row">
                        <h3>Check in</h3>
                        <div>
                            <span>12:00AM</span>
                        </div>
                    </div>
                    <div class="condition-box-row flex-column flex-md-row">
                        <h3>Check out</h3>
                        <div>
                            <span>12:00AM</span>
                        </div>
                    </div>
                    <div class="condition-box-row flex-column flex-md-row">
                        <h3>Hotel Rules</h3>
                        <div>
                            <div class="condition-box-text">
                                <h4>Cancellations</h4>
                                <p>On the day of arrival (18:00)</p>
                            </div>
                            <div class="condition-box-text">
                                <h4>Cancellations</h4>
                                <p>On the day of arrival (18:00)</p>
                            </div>
                            <div class="condition-box-text">
                                <h4>Cancellations</h4>
                                <p>On the day of arrival (18:00)</p>
                            </div>
                            <span class="learn-more">Learn more</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>





























        <section class="subscribe-section">
            <div class="subscribe-text-block">
                <h2>Subscribe</h2>
                <h3>Sign up and we'll send the best deals to you</h3>
                <div class="subscribe-form">
                    <form action="" class="subscribe-form">
                        <input type="mail" placeholder="E-mail">
                        <button class="red-btn">Subscribe</button>
                    </form>
                </div>
            </div>
            <figure class="subscribe-block">
                <img src="{{asset('images/pietro-de-grandi-T7K4aEPoGGk-unsplash.png')}}" alt="">
            </figure>
        </section>
    </main>
</section>
@endsection

@section('scripts')
    <script src="{{ asset('/js/singlePages/single.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection
