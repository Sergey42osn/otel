@extends('layouts.app')

@section('title') booking-page @endsection
@section("styles")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@php
    $user = Auth::user();

    $cancel_message1=$cancel_message2=$cancel1_info=$cancel2_info="";
 if(!empty($request_params['cancel1']) ) {
        if(!str_contains($room->roomable->accommodation->city->tz_offset, '-')){
           $plus_minus = '+';
        } else {
            $plus_minus = '';
        }
        $cancel1_info = $cancelArr[1];
        $cancel2_info = $cancelArr[3];
        $cancel_message1 = __('rooms.cancel_until')." <br>".$request_params['cancel1']." GMT ".$plus_minus." ".$room->roomable->accommodation->city->tz_offset."<br> ".__('rooms.withoutPenalty');
        $cancel_message2= __('rooms.penaltyAmount')." ".$request_params['cancel2']." ".__('rooms.rub');
    }
    if(!empty($request_params['cancel2']))  {
        $cancel_message1= __('rooms.newpenaltyAmount')." ".$request_params['cancel2']." ".__('rooms.rub');

    }
@endphp

@section('contents')
    <section class="banner-section">
        <div class="banner-part" style="background-image:url('images/chris-karidis-QXW1YEMhq_4-unsplash.png')"></div>
    </section>
    <div class="container">
        <section class="breadcrumb-block">
            <span>{{__("booking.homepage")}}</span>
            <span>{{__("booking.search_results")}}</span>
            <span>{{$room->roomable->accommodation->title}}</span>
        </section>
    </div>
    <div class="container">
        @if (session('message'))
            <div class="alert alert-danger text-center">
                {{ session('message') }}
            </div>
        @endif
        <section class="booking-section">
            <form action="{{ route('make-order', ['locale'=>\App::getLocale()]) }}" method="post" class="booking-form">
            <div class="d-flex justify-content-between flex-column flex-md-row ">

                <div class="details-part">
                    <div class="title-part">
                        <h1>{{__("booking.enter_your_details")}}</h1>
                    </div>
                        @csrf
                        <input type="hidden" name="{{isset($request_params['accommodation']) ? 'accommodation' : 'room_id'}}" value="{{isset($request_params['accommodation']) ? $request_params['accommodation'] : $room->id}}">
                        <input type="hidden" name="room_count" value="{{$request_params['room_count']}}">
                        <input type="hidden" name="adults" value="{{$request_params['adults']}}">
                        <input type="hidden" name="children" value="{{$request_params['children'] ?? 0}}">
                        <input type="hidden" name="rooms" value="{{$request_params['rooms'] ?? 1}}">
                        <input type="hidden" name="checkin_date" value="{{$request_params['check_in']}}">
                        <input type="hidden" name="checkout_date" value="{{$request_params['check_out']}}">
                        <input type="hidden" name="room_type_id" value="{{$request_params['room_type_id'] ?? ''}}">
                        <input type="hidden" name="placement_code" value="{{$request_params['placement_code'] ?? ''}}">
                        <input type="hidden" name="rate_plan_id" value="{{$request_params['rate_plan_id'] ?? ''}}">
                        <input type="hidden" name="checksum" value="{{$request_params['check_sum'] ?? ''}}">
                        <input type="hidden" name="price" value="{{$request_params['price']*$request_params['room_count']}}">
                        @if(isset($request_params['children']) && $request_params['children'] > 0)
                            @for($i = 0; $i < count($child_ages); $i++)
{{--                                @if(isset($request_params['child_age_'.$i]))--}}
                                    <input type="hidden" name="child_ages[]" value="{{$child_ages[$i]}}">
{{--                                @endif--}}
                            @endfor

                    @endif
                        <fieldset>
                            <div class="d-flex justify-content-between flex-column flex-md-row">
                                <div class="part-block">
                                    <div>
                                        <label for="">{{__('booking.name')}}</label>
                                        <input type="text" placeholder="{{__('booking.name')}}" name="name" class="name @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                                        <div class="error-field">
                                            @if ($errors->has('name'))
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <label for="">{{__('booking.surname')}}</label>
                                        <input type="text" placeholder="{{__('booking.surname')}}" name="last_name" class="name @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}">
                                        <div class="error-field">
                                            @if ($errors->has('last_name'))
                                                @error('last_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <label for="">{{__('booking.e_mail')}}</label>
                                        <input type="mail" placeholder="{{__('booking.e_mail')}}" name="email" class="email @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                                        <div class="error-field">
                                            @if ($errors->has('email'))
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="part-block">
                                    <div>
                                        <label for="">{{__('booking.phone_number')}}</label>
                                        <input type="tel" placeholder="{{__('booking.phone_number')}}" name="phone" class="phone_number @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                        @if ($errors->has('phone'))
                                            @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>
                                    <div>
                                        <label for="">{{__('booking.gender')}}</label>
                                        <select name="gender" >
                                            <option value="Male" {{$user->gender == '0' ? 'selected' : ''}}>{{__('booking.Male')}}</option>
                                            <option value="Female" {{$user->gender == '1' ? 'selected' : ''}}>{{__('booking.Female')}}</option>
                                        </select>
                                        @if ($errors->has('gender'))
                                            @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>
                                    <div>
                                        <label for="">{{__('booking.cityzen')}}</label>
                                        <select name="cityzen" id="citizen" class="@error('cityzen') is-invalid @enderror">
                                            <option value="">--</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->iso3}}" {{$country->iso3 == old('cityzen') ? 'selected' : ''}}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('cityzen'))
                                            @error('cityzen')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>

{{--                                    <div class="country">--}}
{{--                                        <label for="country">{{__('booking.country/territory')}}</label>--}}
{{--                                        <select name="country" id="country">--}}
{{--                                            @if(!old('country', $user->country))--}}
{{--                                                <option value="" selected disabled hidden>--</option>--}}
{{--                                            @endif--}}
{{--                                            @foreach($countries as $country)--}}
{{--                                                <option value="{{$country->iso3}}" {{$country->id == old('country', $user->country) ? 'selected' : ''}}>{{$country->name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        <div class="error-field">--}}
{{--                                            @error('country')--}}
{{--                                                {{$message}}--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="city">--}}
{{--                                        <label for="city">{{__('booking.city')}}</label>--}}
{{--                                        <select name="city" id="city" class="form-control inputId @error('city') is-invalid @enderror">--}}
{{--                                            <option value="0">{{__('hotel.select_city')}}</option>--}}
{{--                                        </select>--}}

{{--                                    </div>--}}
{{--                                    <div class="Address">--}}
{{--                                        <label for="address">{{__('booking.street_and_building_number')}}</label>--}}
{{--                                        <input id="address" type="text" placeholder="{{__('booking.street_and_building_number')}}" name="address" value="{{ old('address', $user->address) }}" class="@error('address') is-invalid @enderror">--}}
{{--                                        <div class="error-field">--}}
{{--                                            @if ($errors->has('address'))--}}
{{--                                                @error('address')--}}
{{--                                                <div class="text-danger">{{ $message }}</div>--}}
{{--                                                @enderror--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="postcode">--}}
{{--                                        <label for="postcode">{{__('booking.postcode')}}</label>--}}
{{--                                        <input id="postcode" type="text" placeholder="{{__('booking.postcode')}}" name="post_code" value="{{ old('post_code', $user->postal_code) }}" class="@error('post_code') is-invalid @enderror">--}}
{{--                                        <div class="error-field">--}}
{{--                                            @if ($errors->has('post_code'))--}}
{{--                                                @error('post_code')--}}
{{--                                                <div class="text-danger">{{ $message }}</div>--}}
{{--                                                @enderror--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                            <input type="hidden" name="cancel1" value="{{$request_params['cancel1']}}">
                            <input type="hidden" name="cancel2" value="{{$request_params['cancel2']}}">
                            <input type="hidden" name="availability" value="{{$request_params['availability']}}">
                            <input type="hidden" name="room_count" value="{{$request_params['room_count']}}">
                            <div>
                                <label for="">{{__('booking.tell_us_about_your_special_wishes')}}</label>
                                <textarea name="comment" id="comment" placeholder="{{__('booking.content')}}" value="{{ old('comment') }}"></textarea>
                                <div class="error-field">
                                    @error('comment')
                                        {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="d-flex payment-type-form justify-content-between flex-column">
                            @foreach($payment_types as $payment_type)
                                @if ( $room->prepayment && $payment_type->id ==1 )
                                    @continue
                                @endif
                                <div class="align-items-center d-flex">
                                    <input type="radio" id="payment-type-{{$payment_type->id}}" name="payment_type_id" value="{{$payment_type->id}}" class="round-btn">
                                    <label for="payment-type-{{$payment_type->id}}" class="payment-type">{{$payment_type->name}}</label>
                                </div>
                            @endforeach
                                @if ($errors->has('payment_type_id'))
                                    @error('payment_type_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                @endif
                        </fieldset>
{{--                    </form>--}}
                    <div classs="condition-box-row">
                        <div>
                            <div class="condition-box-text">

                                <p>{!! $cancel_message1!!}</p>
                                <p>{!! $cancel_message2!!}</p>
                                <p>{{__('booking.timezone')}} GMT {{!str_contains($room->roomable->accommodation->city->tz_offset, '-') ? '+' : '' }} {{$room->roomable->accommodation->city->tz_offset}}, {{$room->roomable->accommodation->city->tz_name}}</p>
                            </div>
                            <div class="condition-box-text">
{{--                                <h4>{{__('booking.children_policy')}}</h4>--}}
                                <p>{{$room->roomable->accommodation->child_policy}}</p>
                            </div>
                            <div class="condition-box-text">
                                <p>{{$room->roomable->accommodation->other_rules}}</p>
                            </div>
{{--                            <span class="learn-more">Learn more</span>--}}
                        </div>
                    </div>
                </div>
                <div class="info-part">
                    <h3>{{$room->roomable->accommodation->title}}</h3>
                    <div class="hotel-location">
                        <p>{{$room->roomable->accommodation->city->name}}, {{$room->roomable->accommodation->city->country->name}}</p>
                    </div>
                    <figure>
                        <img src="/storage/uploads/{{ $room->roomable->accommodation->featured_image()?$room->roomable->accommodation->featured_image()->url:"" }}" alt="hotel-image">
                    </figure>

                    @if($room->amenities)
                        <ul >
                            @foreach($room->amenities as $amenity)
                                <li class="{{$amenity->icon}} list-item" >{{$amenity->name}}</li>
                            @endforeach
                        </ul>
                    @endif

                    <h4>{{__('booking.your_booking_details')}}</h4>
                    <div class="booking-details-part d-flex">
                        <div class="calendar-input-box">
                            <div>
                                <span class="check">{{__('booking.check_in')}}</span>
                            </div>
                            <span class="date">{{Carbon\Carbon::createFromFormat('m/d/Y', $request_params['check_in'])->format('d/m/Y')}}</span>
                            <span class="time">{{$room->roomable->accommodation->check_ins->from}}</span>
                        </div>
                        <div class="calendar-input-box">
                            <div>
                                <span class="check">{{__('booking.check_out')}}</span>
                            </div>
                            <span class="date">{{Carbon\Carbon::createFromFormat('m/d/Y', $request_params['check_out'])->format('d/m/Y')}}</span>
                            <span class="time">{{$room->roomable->accommodation->check_outs[0]->to}}</span>
                        </div>
                    </div>
                    <div class="booking-details-part stay-details-part">
                        <h5>{{__('booking.total_stay')}}</h5>
                        <span>{{$request_params['date_diff']}} {{trans_choice('booking.nights', $request_params['date_diff'])}}</span>
                        <span>{{$request_params['adults']}} {{trans_choice('booking.adult', $request_params['adults'])}}</span>
                    </div>
                    <div class="booking-details-part choosen-part">
                        <h4>{{__('booking.you_choosed')}}</h4>
                        <span>{{$room->name ? $room->name->name : ''}}</span>
                    </div>
                    <div class="price-box">
                        <span>{{__('booking.price')}}</span>
                        <span>{{number_format($request_params['price']*$request_params['rooms'] ?? 0, 0, '.', ' ')}} {{__('rooms.currency')}}</span>
                    </div>
                    <div>
                        <button class="btn-blue submit-btn">{{__('booking.book_now')}}</button>
                    </div>
                </div>

            </div>
            </form>
        </section>
    </div>
    @include('accommodations.subscription')
    </section>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let lang = '{{App::getLocale()}}';

    // $('#child_ages').select2();

    $("#country").on('change', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('filter-countries')}}",
            type: "POST",
            data: {
                country_iso3: $(this).val()
            },
            success: function(response) {
                $('#city').html('')
                if (response) {
                    let options = response.map(el => `<option value="${el.id}">${el.name[lang]}</option>`)
                    options = `<option value="0" value="0">{{ __('hotel.select_city')}}</option>` + options
                    $('#city').html(options)
                } else {
                    $('#city').html(` <option value="0">{{ __('hotel.select_city')}}</option>`)
                }

            }
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ route('filter-countries')}}",
        type: "POST",
        data: {
            country_iso3: $('#country').val()
        },
        success: function(response) {
            $('#city').html('')
            if (response) {
                let options = response.map(el => `<option value="${el.id}">${el.name}</option>`)
                options = `<option value="0" value="0">{{ __('hotel.select_city')}}</option>` + options
                $('#city').html(options)
            } else {
                $('#city').html(` <option value="0">{{ __('hotel.select_city')}}</option>`)
            }

        }
    });
    // front-end side validation input fields
    // $('.error-field').css({ color: '#E02749' });
    //
    // $('.name').on('focusout', function () {
    //     if (this.value.length < 2) {
    //
    //         let error = 'allowed min characters 2';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     if (this.value.length > 20) {
    //
    //         let error = 'allowed max characters 20';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     this.parentElement.lastElementChild.innerText = '';
    // });
    //
    // $('#city').on('focusout', function () {
    //     if (this.value.length < 2) {
    //
    //         let error = 'allowed min characters 2';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     if (this.value.length > 20) {
    //
    //         let error = 'allowed max characters 20';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     this.parentElement.lastElementChild.innerText = '';
    // });
    //
    // $('#address').on('focusout', function () {
    //     if (this.value.length < 2) {
    //
    //         let error = 'allowed min characters 2';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     if (this.value.length > 20) {
    //
    //         let error = 'allowed max characters 20';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     this.parentElement.lastElementChild.innerText = '';
    // });
    //
    // $('#postcode').on('focusout', function () {
    //     if (this.value.length < 3) {
    //
    //         let error = 'allowed min characters 3';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     if (this.value.length > 15) {
    //
    //         let error = 'allowed max characters 15';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     this.parentElement.lastElementChild.innerText = '';
    // });
    //
    // $('#comment').on('focusout', function () {
    //     if (this.value.length < 3) {
    //
    //         let error = 'allowed min characters 3';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     if (this.value.length > 500) {
    //
    //         let error = 'allowed max characters 500';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     this.parentElement.lastElementChild.innerText = '';
    // });
    //
    // $('.email').on('focusout', function () {
    //     if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.value)) {
    //         return true;
    //     } else {
    //
    //         let error = 'invalid email address';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     this.parentElement.lastElementChild.innerText = '';
    // });
    //
    // $('.phone_number').on('focusout', function () {
    //     if (!/^\+(?:[0-9] ?){6,14}[0-9]$/.test(this.value)) {
    //
    //         let error = 'invalid phone number';
    //         this.parentElement.lastElementChild.innerText = '';
    //         this.parentElement.lastElementChild.innerText = error;
    //         return;
    //     }
    //
    //     this.parentElement.lastElementChild.innerText = '';
    // });
    // $('.submit-btn').click(function () {
    //     $('.booking-form').submit();
    // });
</script>
{{--    <form method="POST"  class="application"  accept-charset="UTF-8" action="https://partner.life-pay.ru/alba/input/">--}}
{{--        <input type="hidden" name="key" value="rTOUoUOiWAA75BVjJdreFLiypjwVkhkdyP4z/WBTgVE=" />--}}
{{--        <input type="hidden" name="cost" value="1000" />--}}
{{--        <input type="hidden" name="name" value="Name" />--}}
{{--        <input type="hidden" name="default_email" value="email@email.em" />--}}
{{--        <input type="hidden" name="order_id" value="1" />--}}
{{--        <input type="image" id="a1lite_button" style="border: 0;" src="https://partner.life-pay.ru/gui/images/a1lite_buttons/button_small.png" value="Оплатить" />--}}
{{--    </form>--}}
@endsection
