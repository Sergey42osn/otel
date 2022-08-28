@extends('layouts.app')

@section('title') booking-success @endsection
@php
    $cancel_message1=$cancel_message2=$cancel1_info=$cancel2_info="";
     if(!empty($order->cancel1) ) {
            if(!str_contains(App\Models\City::find($order->city_id)->tz_offset, '-')){
               $plus_minus = '+';
            } else {
                $plus_minus = '';
            }
            $cancel_message1 = __('rooms.cancel_until')." <br>".$order->cancel1." GMT ".$plus_minus." ".App\Models\City::find($order->city_id)->tz_offset."<br> ".__('rooms.withoutPenalty');
            $cancel_message2= __('rooms.penaltyAmount')." ".$order->cancel2." ".__('rooms.rub');
        }
        if(!empty($order->cancel2))  {
            $cancel_message1= __('rooms.newpenaltyAmount')." ".$order->cancel2." ".__('rooms.rub');

        }
@endphp
@section('contents')
    <main id="success-booking-page">
		<section class="banner-section">
			<div class="banner-part" style="background-image:url({{ asset('images/chris-karidis-QXW1YEMhq_4-unsplash.png') }})"></div>
		</section>
        <div class="container">
            <section class="breadcrumb-block">
                <span>{{ __('booking.homepage') }}</span>
                <span>{{ __('booking.search_results') }}</span>
                <span>{{ $order->object_title }}</span>
            </section>
        </div>
        <div class="container">
            <div class="title-part">
                <div>
                    <h1>{{ __('booking.request_text') . ' ' }}<span>{{ $order->email }}</span></h1>
                    <p><span>{{ Auth::user()->name }}</span>
                        <span>{{ __('booking.request_email_text') }}</span>
                    </p>
                </div>
            </div>
            <section class="booking-section">
                <div class="d-flex justify-content-between flex-column flex-md-row align-items-start">
                    <div class="details-part">
                        <div class="success-detail-part">
                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">
                                <span>{{ __('booking.name') }}</span>
                                <span>{{ $order->name }}</span>
                            </div>
                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">
                                <span>{{ __('booking.surname') }}</span>
                                <span>{{ $order->lastName }}</span>
                            </div>
                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">
                                <span>{{ __('booking.e_mail') }}</span>
                                <span>{{ $order->email }}</span>
                            </div>
                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">
                                <span>{{ __('booking.phone_number') }}</span>
                                <span>{{ $order->phone }}</span>
                            </div>
{{--                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">--}}
{{--                                <span>{{ __('booking.country/territory') }}</span>--}}
{{--                                <span>{{ \App\Models\Country::find($order->country_id)?->name }}</span>--}}
{{--                            </div>--}}
{{--                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">--}}
{{--                                <span>{{ __('booking.city') }}</span>--}}
{{--                                <span>{{ \App\Models\City::find($order->city_id)?->name }}</span>--}}
{{--                            </div>--}}
{{--                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">--}}
{{--                                <span>{{ __('booking.address') }}</span>--}}
{{--                                <span>{{ $order->address }}</span>--}}
{{--                            </div>--}}
{{--                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">--}}
{{--                                <span>{{ __('booking.postcode') }}</span>--}}
{{--                                <span>{{ $order->postcode }}</span>--}}
{{--                            </div>--}}
                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">
                                <span>{{ __('booking.content') }}</span>
                                <span>{{ $order->special_wishes }}</span>
                            </div>
                            <div class="detail-row d-flex justify-content-between flex-column flex-md-row">
                                <span>{{ __('booking.payment_title') }}</span>
                                <span>{{ \App\Models\Payment::find($order->payment)->name }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <p  style="font-weight: 600;padding-left: 27px">{!! $cancel_message1  !!} </p>
                            <p  style="font-weight: 600;padding-left: 27px">{!! $cancel_message2 !!} </p>

                        </div>
                        <div class="condition-box-row">
                            <div>
                                <div class="condition-box-text">
                                    <h4>{{ __('booking.attention_title') }}</h4>
                                    <p>{{ __('booking.attention_text') }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="info-part">
                        <h3>{{ $order->object_title }}</h3>
                        <div class="hotel-location">
                            <p>{{ (\App\Models\City::find($order->city_id)?->name ? \App\Models\City::find($order->city_id)->name . ', ' : '') . (\App\Models\Country::find($order->country_id)?->name ? \App\Models\Country::find($order->country_id)->name : '') }}</p>
                        </div>
                        <figure>
                            <img src="/storage/uploads/{{$accommodation->featured_image() ?$accommodation->featured_image()->url:"" }}" alt="hotel-image">
                        </figure>
                        <h4>{{ __('booking.your_booking_details') }}</h4>
                        <div class="booking-details-part d-flex">
                            <div class="calendar-input-box">
                                <div>
                                    <span class="check">{{ __('booking.check_in') }}</span>
                                </div>
                                <span class="date">{{ $order->check_in }}</span>
                                <!-- <span class="time">14:00-00:00</span> -->
                            </div>
                            <div class="calendar-input-box">
                                <div>
                                    <span class="check">{{ __('booking.check_out') }}</span>
                                </div>
                                <span class="date">{{ $order->check_out }}</span>
                                <!-- <span class="time">14:00-00:00</span> -->
                            </div>
                        </div>
                        <div class="booking-details-part stay-details-part">
                            <h5>{{ __('booking.total_stay') }}</h5>
                            <span>{{ $order->duration ? $order->duration : '0' }} {{ trans_choice('booking.nights', $order->duration) }}</span>
                            <span>{{ $order->adults ? $order->adults : '0' }} {{ trans_choice('booking.adult', $order->adults) }}</span>
                        </div>
                        <div class="booking-details-part choosen-part">
                            <h4>{{ __('booking.you_choosed') }}</h4>
                            <span>{{ $order->room_name }}</span>
                        </div>
                        <div class="price-box">
                            <span>{{ __('booking.price') }}</span>
                            <span>{{ number_format($order->price, 0, '.', ' ') }} {{ __('booking.rub') }}</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('accommodations.subscription')
    </main>
@endsection
