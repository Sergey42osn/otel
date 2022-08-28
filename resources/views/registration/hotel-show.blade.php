@extends('layouts.vendor')
@section("styles")
    <link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/css/intlTelInput.css" />
@endsection
@section('contents')
    @php
        $langauges = $hotel->accommodation->langs->pluck('id')->toArray();
        $langauges_str = $hotel->accommodation->langs->pluck('id');
        $selectedAmenity = $hotel->accommodation->amenities->pluck('id')->toArray();
        $selectedAmenity_str = $hotel->accommodation->amenities->pluck('id');
        $selectedPayments = $hotel->accommodation->payments->pluck('id')->toArray();

    @endphp
    <section class="banner-section">
        <div class="banner-part" style="background-image:url('{{asset("images/chris-karidis-QXW1YEMhq_4-unsplash.png")}}')"></div>
    </section>
    <div id="hotel-page">
        <div class="container">
            <div class="title-part">
                @if($hotel->accommodation->type == 'hotel')
                    <h1>{{__('hotel.hotel_general_information') }}</h1>
                @else
                    <h1>{{__('hotel.youth_hotel_general_information')}}</h1>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <p><strong>Opps Something went wrong</strong></p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <form action="{{ route('hotels.update', ['locale' => App::getLocale(), 'hotel' => $hotel])}}" class="hotel-form general-form" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="accommodation_type" value="{{$hotel->accommodation->type}}">
                <section class="general-info-block info-block ">
                    <div class="row mb-2 input-block">
                        <div class="text-block">
                            <p>{{ __('hotel.sales_desc')}}</p>
{{--                            <p>{{ __('hotel.sales_desc_1')}}</p>--}}
                        </div>
                        <fieldset class="d-flex sales-channel-form justify-content-between flex-column flex-md-row">
                            <div class="part-block sales-channel-inner-form align-items-center d-flex">
                                <label for="use-sales-channel" class=""><input type="radio" id="use-sales-channel" name="sales_channel" class="round-btn" {{ $crms ? 'checked' : ''}}>{{__("hotel.use_sales")}}</label>
                            </div>
                            <div class="part-block sales-channel-inner-form align-items-center d-flex">
                                <label for="not-use-sales-channel" class=""><input type="radio" id="not-use-sales-channel" name="sales_channel" class="round-btn" {{ $crms ? '' : 'checked'}}>{{ __('hotel.not_use_sales')}}</label>
                            </div>
                        </fieldset>
                        <input type="hidden" id="crm_acc_code"  value="{{$crm_acc_code}}"/>
                        <input type="hidden" id="crm_code_with_sale_id"  value="{{$crm_code_with_sale_id}}"/>
                        <input type="hidden" id="this_acc_id"  value="{{$this_acc_id}}" />
                        <input type="hidden" id="crm_acc_ids"  value="{{$crm_acc_ids}}" />
                        <div class="mb-3 mt-1 row {{ $crms ? '' : 'd-none'}}" id="crm_div" style="padding-right: 0">
                            <div class="col-sm-6">
                                <label for="crm" class="form-label">{{__('hotel.crm')}}</label>
                                <select class="form-select" name="sale_channel_id" id="sale_channel_id">
                                    <option value="">-</option>
                                    @if(App::getLocale() == 'ru')
                                        @foreach($ru_sale_channels as $ru_sale_channel)
                                            <option value="{{$loop->index+1}}" {{$crms && $crms->sale_channel_id == $loop->index+1  ? 'selected' : ''}}>{{$ru_sale_channel}}</option>
                                        @endforeach
                                    @else
                                        @foreach($en_sale_channels as $en_sale_channel)
                                            <option value="{{$loop->index+1}}" {{$crms && $crms->sale_channel_id == $loop->index+1  ? 'selected' : ''}}>{{$en_sale_channel}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-6" style="padding-right: 0;padding-left:20px">
                                <label for="crm" class="form-label">{{__('hotel.crm')}}</label>
                                <input type="text" name="crm_code" id="crm" value="{{$crms ?$crms->accommodation_crm_code:''}}"/>
                                <div id="unique_crm" style="color:red;display:none">Crm is unique</div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-between flex-column flex-md-row">
                        <div class="general-info-inner-block input-block">
                            <fieldset class="general-info-form">
                                <div class="type">
                                    <label for="type">{{ __('hotel.object_type')}}*</label>
                                    <select name="type" id="type" class="form-control inputId">
                                        <option value="">{{ __('hotel.select_type')}}</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}" {{ $hotel->type_id == $type->id ? 'selected ': ''}}>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <section class="name-block info-block">
                                    <div class="">
                                        <div class="title-part">
                                            <label for="name">{{ __('hotel.hotel_name')}}*</label>
                                        </div>
                                        <div>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <label for="" class="d-block"></label>
                                                <div class="name-btn-group d-flex justify-content-end name-change-box">
                                                    <button type="button" class="active" id="pyc_name">{{ __('hotel.pyc')}}</button><button type="button" id="eng_name">{{ __('hotel.eng')}}</button>
                                                </div>
                                            </div>
                                            <div class="name-change-box">
                                                <input id="name_pyc" type="text" placeholder="{{ __('hotel.property_name_placeholder')}}" name="title_pyc" class="active form-control inputId" value="{{ $hotel->accommodation->getTranslation('title', 'ru')}}">
                                                <input id="name" type="text" placeholder="{{ __('hotel.property_name_placeholder')}}" name="title" class="form-control inputId" value="{{ $hotel->accommodation->getTranslation('title', 'en')}}">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="stars">
                                    <label for="stars">{{ __('hotel.stars')}}*</label>
                                    <select name="{{ $hotel->in_stock == '1' ? 'stars_num' : ''}}" id="stars" style="font-size:120%; color:#FAAF40;" class="form-control inputId {{ $hotel->in_stock != '1' ? 'd-none' : ''}}">
                                        <option value="0" style="font-size:120%; color:#000;" class="op0">-</option>
                                        <option value="1" style="font-size:120%; color:#FAAF40;" class="op1" {{ $hotel->stars_num == '1' ? 'selected' : ''}}>&starf;</option>
                                        <option value="2" style="font-size:120%; color:#FAAF40;" class="op2" {{ $hotel->stars_num == '2' ? 'selected' : ''}}>&starf;&starf;</option>
                                        <option value="3" style="font-size:120%; color:#FAAF40;" class="op3" {{ $hotel->stars_num == '3' ? 'selected' : ''}}>&starf;&starf;&starf;</option>
                                        <option value="4" style="font-size:120%; color:#FAAF40;" class="op4" {{ $hotel->stars_num == '4' ? 'selected' : ''}}>&starf;&starf;&starf;&starf;</option>
                                        <option value="5" style="font-size:120%; color:#FAAF40;" class="op5" {{ $hotel->stars_num == '5' ? 'selected' : ''}}>&starf;&starf;&starf;&starf;&starf;</option>
                                    </select>
                                    <select id="stocks_star"  name="{{ $hotel->in_stock != '1' ? 'stars_num' : ''}}"  style="font-size:120%; color:#FAAF40;" class="form-control inputId {{ $hotel->in_stock == '1' ? 'd-none':'' }}">
                                        <option value="0" style="font-size:120%; color:#000;" class="op0" >-</option>
                                        <option value="1" style="font-size:120%; color:#FAAF40;" class="op1" {{ $hotel->stars_num == '1' ? 'selected' : ''}}>•</option>
                                        <option value="2" style="font-size:120%; color:#FAAF40;" class="op2" {{ $hotel->stars_num == '2' ? 'selected' : ''}}>••</option>
                                        <option value="3" style="font-size:120%; color:#FAAF40;" class="op3" {{ $hotel->stars_num == '3' ? 'selected' : ''}}>•••</option>
                                        <option value="4" style="font-size:120%; color:#FAAF40;" class="op4" {{ $hotel->stars_num == '4' ? 'selected' : ''}}>••••</option>
                                        <option value="5" style="font-size:120%; color:#FAAF40;" class="op5" {{ $hotel->stars_num == '5' ? 'selected' : ''}}>•••••</option>
                                    </select>
                                </div>
                                <div class="d-flex">
                                    <input type="checkbox" id="star_with_stock" name="in_stock" class="form-check-input" {{ $hotel->in_stock == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label star-stock-label" for="star_with_stock">{{ __('hotel.in_stock')}}</label>
                                </div>
                                <span>{{ __('hotel.valid_address')}}</span>
                                <div class="country">
                                    <label for="country">{{ __('hotel.country')}}*</label>
                                    <select name="country" id="country" class="form-control inputId">
                                        <option value="0">{{ __('hotel.select_country')}}</option>
                                        @foreach($countries as $country)
                                            <option data-iso="{{$country->iso2}}" value="{{$country->id}}" {{ $hotel->accommodation->country_id == $country->id ? 'selected' : ''}}>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" value="{{$iso2}}" id="countries_codes">
                                </div>
                                <div class="city">
                                    <label for="city">{{ __('hotel.city')}}*</label>
                                    <select name="city" id="city" class="form-control inputId">
                                        <option value="0">{{__('hotel.select_city')}}</option>
                                        <option value="{{$hotel->accommodation->city_id}}"  selected>{{$hotel->accommodation->city_name()}}</option>
                                    </select>
                                </div>
                                <div class="street">
                                    <label for="street">{{ __('hotel.street_house')}}*</label>
                                    <input id="street" type="text" placeholder="Street and build number" name="street_house" class="form-control inputId" value="{{$hotel->accommodation->address->street_house ?? ''}}">
                                </div>
                                <div class="zip">
                                    <label for="zip">{{ __('hotel.zip_code')}}*</label>
                                    <input id="zip" type="text" placeholder="ZIP code" name="zip_code" class="form-control inputId" value="{{$hotel->accommodation->address->zip_code ?? ''}}">
                                </div>
                            </fieldset>
                        </div>
                        <div class="map-block">
                            <div id="mymap" style="width: 100%; height: 100%"></div>
                            <input type="hidden" name="map" value="{{$hotel->accommodation->address->map ?? ''}}">
                        </div>
                    </div>
                </section>
                <section class="personal-info-block info-block">
                    <div class="personal-info-inner-block input-block">
                        <div class="title-part">
                            <h2>{{ __('hotel.contact_title')}}</h2>
                        </div>
                        <fieldset class="d-flex personal-info-form flex-column flex-md-row">
                            <div class="part-block">
                                <div class="person">
                                    <label for="person">{{__('hotel.contact_person')}}*</label>
                                    <input id="person" type="text" placeholder="Name Surname" name="contact_person" value="{{$hotel->accommodation->contact_person ?? ''}}" class="inputId">
                                </div>
                                <div class="number">
                                    <label for="city">{{ __('hotel.phone')}}* </label>
                                    <input type="text" id="phone" name="phone_number" class="form-control inputId">
                                    <input type="hidden" name="phone" value="{{$hotel->accommodation->phone ?? ''}}">
                                </div>
                            </div>
                            <div class="part-block">
                                <div class="city">
                                    <label for="city">{{ __('hotel.additional_phone')}}</label>
                                    <input type="text" id="alt_phone" class="form-control">
                                    <input type="hidden" name="alt_phone" value="{{$hotel->accommodation->alt_phone ?? ''}}">

                                </div>
                            </div>
                        </fieldset>
                    </div>
                </section>
                <section class="language-block info-block">
                    <div class="input-block">
                        <div class="title-part">
                            <h2>{{ __('hotel.langs_title')}}</h2>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <fieldset class="d-flex justify-content-between flex-wrap language-form flex-column flex-md-row">
                                    @foreach($langs as $lang)
                                        <div class="part-block">
                                            <input type="checkbox" id="langs_{{$lang->id}}" name="langs[]" value="{{$lang->id}}" {{ in_array($lang->id, $langauges) ? 'checked' : '' }}>
                                            <label for="langs_{{$lang->id}}" class="checkBtn-label">{{$lang->name}}</label>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>
                            <div class="col-sm-4">
                                <select name="langs[]" id="ex-multiselect" multiple="multiple" >
                                    @foreach($langs_select as $lang_sel)
                                        <option id="langs_sel_{{$lang_sel->id}}" value="{{ $lang_sel->id }}"> {{ $lang_sel->name }}</option>
                                    @endforeach
                                    <input type="hidden" value="{{$langauges_str}}" id="langauges"/>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="services-block info-block">
                    <div class="input-block">
                        <div class="title-part">
                            <h2>{{ __('hotel.services')}}</h2>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <fieldset class="d-flex justify-content-between flex-wrap services-form flex-column flex-md-row">
                                    @foreach($amenities as $amenity)
                                        <div class="part-block">
                                            <input type="checkbox" id="amenity_{{$amenity->id}}" name="amenities[]" value="{{$amenity->id}}" {{ in_array($amenity->id, $selectedAmenity) ? 'checked' : '' }}>
                                            <label for="amenity_{{$amenity->id}}" class="checkBtn-label">{{$amenity->name}}</label>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>
                            <div class="col-sm-4">
                                <select name="amenities[]" id="service-multiselect" multiple="multiple">
                                    @foreach($amenities_select as $amenity_sel)
                                        <option id="amenity_sel{{$amenity_sel->id}}" value="{{ $amenity_sel->id }}">{{ $amenity_sel->name }}</option>
                                    @endforeach
                                    <input type="hidden" value="{{$selectedAmenity_str}}" id="amenities"/>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>

                <x-file-select :images="$hotel->images" />
                <section class="check-in-out-block info-block d-flex flex-column flex-md-row">
                    <div class="input-block part-block ">
                        <div class="check-in-block">
                            <div class="title-part">
                                <h2>{{ __('hotel.check_in')}}</h2>
                            </div>
                            <fieldset class="check-in-out-form">
                                <div class="check-in-from">
                                    <label for="in-from">{{ __('hotel.from')}}*</label>
                                    <select name="check_in_from" id="in-from" class="form-control inputId">
                                        <option value="0">{{ __('hotel.select')}}</option>
                                        <option value="00:00" {{isset($hotel->accommodation->check_ins) && $hotel->accommodation->check_ins->from == '00:00:00'?'selected': ''}}>00:00</option>
                                        <option value="01:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '01:00:00'?'selected': ''}}>01:00</option>
                                        <option value="02:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '02:00:00'?'selected': ''}}>02:00</option>
                                        <option value="03:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '03:00:00'?'selected': ''}}>03:00</option>
                                        <option value="04:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '04:00:00'?'selected': ''}}>04:00</option>
                                        <option value="05:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '05:00:00'?'selected': ''}}>05:00</option>
                                        <option value="06:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '06:00:00'?'selected': ''}}>06:00</option>
                                        <option value="07:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '07:00:00'?'selected': ''}}>07:00</option>
                                        <option value="08:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '08:00:00'?'selected': ''}}>08:00</option>
                                        <option value="09:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '09:00:00'?'selected': ''}}>09:00</option>
                                        <option value="10:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '10:00:00'?'selected': ''}}>10:00</option>
                                        <option value="11:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '11:00:00'?'selected': ''}}>11:00</option>
                                        <option value="12:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '12:00:00'?'selected': ''}}>12:00</option>
                                        <option value="13:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '13:00:00'?'selected': ''}}>13:00</option>
                                        <option value="14:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '14:00:00'?'selected': ''}}>14:00</option>
                                        <option value="15:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '15:00:00'?'selected': ''}}>15:00</option>
                                        <option value="16:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '16:00:00'?'selected': ''}}>16:00</option>
                                        <option value="17:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '17:00:00'?'selected': ''}}>17:00</option>
                                        <option value="18:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '18:00:00'?'selected': ''}}>18:00</option>
                                        <option value="19:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '19:00:00'?'selected': ''}}>19:00</option>
                                        <option value="20:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '20:00:00'?'selected': ''}}>20:00</option>
                                        <option value="21:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '21:00:00'?'selected': ''}}>21:00</option>
                                        <option value="22:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '22:00:00'?'selected': ''}}>22:00</option>
                                        <option value="23:00" {{isset($hotel->accommodation->check_ins) &&  $hotel->accommodation->check_ins->from == '23:00:00'?'selected': ''}}>23:00</option>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="input-block part-block ">
                        <div class="check-out-block">
                            <div class="title-part">
                                <h2>{{ __('hotel.check_out')}}</h2>
                            </div>
                            <fieldset class="check-in-out-form">
                                <div class="check-out-to">
                                    <label for="out-to">{{ __('hotel.to')}}* </label>
                                    <select name="check_out_to" id="out-to" class="form-control inputId">
                                        <option value="0">{{ __('hotel.select')}}</option>
                                        <option value="00:00" {{ $hotel->accommodation->check_outs[0]->to == '00:00:00' ? 'selected': ''}}>00:00</option>
                                        <option value="01:00" {{ $hotel->accommodation->check_outs[0]->to == '01:00:00' ? 'selected': ''}}>01:00</option>
                                        <option value="02:00" {{ $hotel->accommodation->check_outs[0]->to == '02:00:00' ? 'selected': ''}}>02:00</option>
                                        <option value="03:00" {{ $hotel->accommodation->check_outs[0]->to == '03:00:00' ? 'selected': ''}}>03:00</option>
                                        <option value="04:00" {{ $hotel->accommodation->check_outs[0]->to == '04:00:00' ? 'selected': ''}}>04:00</option>
                                        <option value="05:00" {{ $hotel->accommodation->check_outs[0]->to == '05:00:00' ? 'selected': ''}}>05:00</option>
                                        <option value="06:00" {{ $hotel->accommodation->check_outs[0]->to == '06:00:00' ? 'selected': ''}}>06:00</option>
                                        <option value="07:00" {{ $hotel->accommodation->check_outs[0]->to == '07:00:00' ? 'selected': ''}}>07:00</option>
                                        <option value="08:00" {{ $hotel->accommodation->check_outs[0]->to == '08:00:00' ? 'selected': ''}}>08:00</option>
                                        <option value="09:00" {{ $hotel->accommodation->check_outs[0]->to == '09:00:00' ? 'selected': ''}}>09:00</option>
                                        <option value="10:00" {{ $hotel->accommodation->check_outs[0]->to == '10:00:00' ? 'selected': ''}}>10:00</option>
                                        <option value="11:00" {{ $hotel->accommodation->check_outs[0]->to == '11:00:00' ? 'selected': ''}}>11:00</option>
                                        <option value="12:00" {{ $hotel->accommodation->check_outs[0]->to == '12:00:00' ? 'selected': ''}}>12:00</option>
                                        <option value="13:00" {{ $hotel->accommodation->check_outs[0]->to == '13:00:00' ? 'selected': ''}}>13:00</option>
                                        <option value="14:00" {{ $hotel->accommodation->check_outs[0]->to == '14:00:00' ? 'selected': ''}}>14:00</option>
                                        <option value="15:00" {{ $hotel->accommodation->check_outs[0]->to == '15:00:00' ? 'selected': ''}}>15:00</option>
                                        <option value="16:00" {{ $hotel->accommodation->check_outs[0]->to == '16:00:00' ? 'selected': ''}}>16:00</option>
                                        <option value="17:00" {{ $hotel->accommodation->check_outs[0]->to == '17:00:00' ? 'selected': ''}}>17:00</option>
                                        <option value="18:00" {{ $hotel->accommodation->check_outs[0]->to == '18:00:00' ? 'selected': ''}}>18:00</option>
                                        <option value="19:00" {{ $hotel->accommodation->check_outs[0]->to == '19:00:00' ? 'selected': ''}}>19:00</option>
                                        <option value="20:00" {{ $hotel->accommodation->check_outs[0]->to == '20:00:00' ? 'selected': ''}}>20:00</option>
                                        <option value="21:00" {{ $hotel->accommodation->check_outs[0]->to == '21:00:00' ? 'selected': ''}}>21:00</option>
                                        <option value="22:00" {{ $hotel->accommodation->check_outs[0]->to == '22:00:00' ? 'selected': ''}}>22:00</option>
                                        <option value="23:00" {{ $hotel->accommodation->check_outs[0]->to == '23:00:00' ? 'selected': ''}}>23:00</option>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </section>
                <section class="booking-block info-block">
                    <div class="input-block">
                        <div class="title-part">
                            <h2>{{ __('hotel.booking_cancellation')}}</h2>
                        </div>
                        <fieldset class="d-flex flex-column flex-md-row justify-content-between">
                            <div class="part-block">
                                <label for="book-cancel-days">{{ __('hotel.days_without_pay_penalty')}}</label>
                                <select name="policies[]" id="book-cancel-days">
                                    @foreach($policies->where('type','payable') as $policy)
                                        <option value="{{$policy->id}}" {{ isset($hotel->accommodation->policies->where('type','payable')[0]) && $hotel->accommodation->policies->where('type','payable')[0]->id == $policy->id ? 'selected' : ''}}>{{ $policy->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="part-block">
                                <label for="">{{ __('hotel.guest_pay_100')}}</label>
                                <select name="policies[]" id="booking_guest_pay">
                                    @foreach($policies->where('type','not_payable') as $policy)
                                        <option value="{{$policy->id}}" {{ isset($hotel->accommodation->policies->where('type','not_payable')[1]) && $hotel->accommodation->policies->where('type','not_payable')[1]->id == $policy->id ? 'selected' : ''}}>{{ $policy->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        <div class="cancel-text-block bg-blue-block">
                            <p class="cancel-text">{{ __('hotel.guest_cancel')}} <span class="cancel_day"></span> {{ __('hotel.or')}} <span class="guest_pay"></span> .</p>
                            <p class="note-text">{{ __('hotel.note')}}</p>
                        </div>
                        <div class="form-check form-switch d-flex">
                            <h3>{{__('hotel.protection_booking')}}</h3>
                            <input class="form-check-input" name="protection_booking" type="checkbox" id="clickOnOff" {{$hotel->accommodation->protection_booking == 'on' ? 'checked' : ''}}>
                            <label class="form-check-label" for="" class="checkBtn-label">Yes</label>
                        </div>
                        <div>
                            <p class="note-text">{{ __('hotel.save_cancellation_info')}}</p>
                        </div>
                    </div>
                </section>
                <section class="child-block info-block">
                    <div class="input-block">
                        <div class="">
                            <div class="title-part">
                                <h2>{{__('hotel.children.title')}}</h2>
                            </div>
                            <fieldset class="child-allow-part">
                                <div class="part-block">
                                    <label for="child-allow">{{ __('hotel.children.allowed_child')}}</label>
                                    <select name="allow_child" id="child-allow">
                                        <option value="1" {{ $hotel->accommodation->allow_child == '1' ? 'selected' : ''}}>{{__('hotel.yes')}}</option>
                                        <option value="0" {{ $hotel->accommodation->allow_child == '0' ? 'selected' : ''}}>{{__('hotel.no')}}</option>
                                    </select>


                                </div>
                                <div class="d-flex justify-content-between align-items-end label-part">
                                    <label for="" class="d-block">{{__("hotel.children.policy")}}</label>
                                    <div class="lang-btn-group d-flex justify-content-end lang-change-box">
                                        <button class="active" id="pyc_child" type="button">Рус</button><button type="button" id="eng_child">Eng</button>
                                    </div>
                                </div>
                                <div class="lang-change-box">
                                    <textarea name="child_policy_pyc" id="child_policy_pyc" placeholder="Content" class="active">{{$hotel->accommodation->getTranslation('child_policy','ru') ?? ''}}</textarea>
                                    <textarea name="child_policy" id="child_policy" placeholder="Content">{{$hotel->accommodation->getTranslation('child_policy','en') ?? ''}}</textarea>
                                </div>
                        </div>
                    </div>
                </section>
                <section class="rules-block info-block">
                    <div class="input-block">
                        <div class="rules-inner-block">
                            <div class="title-part">
                                <h2>{{ __('hotel.rules')}}</h2>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <label for="" class="d-block">{{ __('hotel.rules')}}</label>
                                <div class="lang-btn-group d-flex justify-content-end lang-change-box">
                                    <button class="active" id="pyc_rule" type="button">Рус</button><button type="button" id="eng_rule">Eng</button>
                                </div>
                            </div>
                            <div class="lang-change-box">
                                <textarea name="other_rules_pyc" id="other_rules_pyc" placeholder="Content" class="active">{{$hotel->accommodation->getTranslation('other_rules','ru') ?? ''}}</textarea>
                                <textarea name="other_rules" id="other_rules" placeholder="Content">{{$hotel->accommodation->getTranslation('other_rules','en') ?? ''}}</textarea>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="pet-block info-block">
                    <div class="input-block">
                        <div class="pet-inner-block">
                            <div class="title-part">
                                <h2>{{ __('hotel.pets.title')}}</h2>
                            </div>
                            <div class="part-block">
                                <label for="pet-allow">{{ __('hotel.pets.question')}}</label>
                                <select name="allow_pets" id="pet-allow">
                                    <option value="0" {{ $hotel->accommodation->allow_pets == '0' ? 'selected' : ''}}>{{ __('hotel.pets.not_allowed')}}</option>
                                    <option value="1" {{ $hotel->accommodation->allow_pets == '1' ? 'selected' : ''}}>{{ __('hotel.pets.allowed')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="payment-method-block info-block">
                    <div class="input-block">
                        <div class="">
                            <div class="title-part">
                                <h2>{{ __('hotel.payments.title')}}</h2>
                            </div>
                            <div>
                                <fieldset class="payment-method-form d-flex flex-column flex-md-row">
                                    @foreach($payments as $payment)
                                        <div>
                                            <input type="checkbox" id="card-method-{{ $payment->id }}" name="payments[]" class="round-btn" value="{{$payment->id}}" {{ in_array($payment->id , $selectedPayments) ? 'checked' : ""}}>
                                            <label class="align-items-center d-flex checkBtn-label" for="card-method-{{ $payment->id }}">{{$payment->name}}</label>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="description-block info-block">
                    <div class="input-block">
                        <div class="">
                            <div class="title-part">
                                <h2>{{ __('hotel.description')}}*</h2>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <label for="" class="d-block">{{ __('hotel.description')}}</label>
                                    <div class="lang-btn-group d-flex justify-content-end lang-change-box">
                                        <button type="button" class="active" id="pyc_desc">Рус</button><button type="button" id="eng_desc">Eng</button>
                                    </div>
                                </div>
                                <div class="lang-change-box">
                                    <textarea name="description_pyc" id="description_pyc" placeholder="{{ __('hotel.content_placeholder')}}" class="active form-control inputId">{{ $hotel->accommodation->getTranslation('description','ru') ?? ''}}</textarea>
                                    <textarea name="description" id="description" placeholder="{{ __('hotel.content_placeholder')}}" class="inputId">{{ $hotel->accommodation->getTranslation('description','en') ?? ''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    @forelse ($hotel->rooms as $room)
                        <div class="bg-blue-block d-flex flex-column flex-md-row added-room-block justify-content-between" id="{{$room->id}}">
                            <div class="added-room-text">
                                <p>{{$room->type?$room->type->name:''}}</p>
                            </div>
                            <div class="quantity-box">
                                <span>{{__('rooms.quantity')}}: </span>
                                <span class="room-quantity">{{$room->number}}</span>
                            </div>
                            <div class="d-flex flex-row flex-md-column added-room-btn-block">
                                <a href="{{route("rooms.edit", ['locale' => App::getLocale(), 'room' => $room])}}" class="btn btn-blue">edit</a>
                                <button type="button" class="btn btn-grey deleteRoom" data-url="{{route('rooms.destroy',['locale' => App::getLocale(), 'room' => $room])}}" id="btn-delete{{$room->id}}">delete</button>
                            </div>
                        </div>

                    @empty

                    @endforelse

                    <a href="{{route('rooms.create', ['locale' => App::getLocale(),'hotel_id' => $hotel->id])}}" class="btn add-btn">
                        <i></i>{{__('hotel.add_room')}}</a>
                </section>
                <section class="-block info-block">
                    <div class="input-block">
                        <div class="title-part">
                            <h2>{{ __('hotel.terms_conditions.title')}}</h2>
                        </div>
                        <fieldset class="certify-form">
                            <div class="d-flex">
                                <input type="checkbox" id="certificate" name="certify_terms" required class="inputId" checked>
                                <label for="certificate" class="checkBtn-label">{{ __('hotel.terms_conditions.certify_term')}}</label>
                            </div>
                            <div class="d-flex">
                                <input type="checkbox" id="terms-conditions" name="agree_terms" class="inputId" checked>
                                <label for="terms-conditions" class="checkBtn-label"><p> {!! __('hotel.terms_conditions.agree_term', ['href1' => route('agency-contract-offer', ['locale' => App::getLocale()]), 'href2' => route('legal-page', ['locale' => App::getLocale()])])!!}</p></label>
                            </div>
                        </fieldset>
                        <div class="bg-blue-block">
                            <p>{{ __('hotel.terms_conditions.desc')}}</p>
                        </div>
                    </div>
                </section>
                <div class="btn-block">
                    <a href="{{ url()->previous() }}" class="btn btn-white btn-back"><i></i> {{ __('hotel.btn_back')}}</a>
                    <button class="btn btn-blue saveBtn" type="submit">{{ __('hotel.btn_save')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
    <x-yandex-map :coords="$hotel->accommodation->address->map" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js" integrity="sha512-Wkxbeuy81yHqZNrMurMURCOCMzkJqaFYnvToublHiOGoVXQ2DS1lOUjKwstbe0GwELrRb9sicdV2y6GiAnVxuw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="/js/intlTelInput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script>
        let crm_acc_ids = $('#crm_acc_ids').val().split(',');
        let crm_acc_code = $('#crm_acc_code').val().split(',');
        let crm_code_with_sale_id =$('#crm_code_with_sale_id').val().split(',');
        let this_acc_id = $('#this_acc_id').val();
        let locale = '{{App::getLocale()}}';

        $('#sale_channel_id').change(function (){
            $('#unique_crm').css('display','none');
            for( let j = 0;j<crm_code_with_sale_id.length;j++){
                if(crm_code_with_sale_id[j] == $(this).val()){
                    for(let i=0;i<crm_code_with_sale_id.length;i++){
                        if( crm_code_with_sale_id[i]==$(this).val() && crm_acc_code[i]==$('#crm').val()){
                            if(this_acc_id!==crm_acc_ids[i]){
                                $('#unique_crm').css('display','block');
                            }
                        }
                        if(this_acc_id==crm_acc_ids[i] && crm_code_with_sale_id[i]==$('#sale_channel_id').val() && crm_acc_code[i]!=$('#crm').val()){
                            $('#unique_crm').css('display','block');
                        }
                    }
                    break;
                }
            }
        });
        $('#crm').change(function (){
            $('#unique_crm').css('display','none');
            for( let j = 0;j<crm_code_with_sale_id.length;j++){
                if(crm_code_with_sale_id[j] == $('#sale_channel_id').val()){
                    for(let i=0;i<crm_code_with_sale_id.length;i++){
                            if(crm_code_with_sale_id[i]==$('#sale_channel_id').val() && crm_acc_code[i]==$(this).val() ){
                                console.log(2);
                                if(this_acc_id!==crm_acc_ids[i]){
                                    $('#unique_crm').css('display','block');
                                }
                            }
                        if(this_acc_id==crm_acc_ids[i] && crm_code_with_sale_id[i]==$('#sale_channel_id').val() && crm_acc_code[i]!=$(this).val()){
                            $('#unique_crm').css('display','block');
                        }
                    }
                    break;
                }
            }
        });
        $("#book-cancel-days").change(function (){
            $(".cancel_day").html($("#book-cancel-days").find('option:selected').html());
        });
        $("#booking_guest_pay").change(function (){
            $(".guest_pay").html($("#booking_guest_pay").find('option:selected').html());
        });
        $(".cancel_day").html($("#book-cancel-days").find('option:selected').html());
        $(".guest_pay").html($("#booking_guest_pay").find('option:selected').html());
        const checkbox = document.getElementById('star_with_stock');
        checkbox.addEventListener('change', (event) => {
            if (!$('#star_with_stock').prop( "checked") ){
                if ( $("#stocks_star").hasClass("d-none") ){
                    $('#stocks_star').removeClass('d-none');
                }
                $('#stars').attr('name','');
                $('#stars').addClass('d-none');
                $('#stocks_star option').removeAttr('selected');
                let selected_option_id = $('#stars').find('option:selected').attr('class');
                $('#stocks_star').find('.'+selected_option_id).attr('selected','true');
                $("#stocks_star").removeClass('is-invalid inputId');
                $('#stocks_star').attr('name','stars_num');
                $('#stars-error').remove();
            } else {
                if ( $("#stars").hasClass('d-none') ){
                    $('#stars').removeClass('d-none');
                }
                $('#stars option').removeAttr('selected');
                let selected_option_id = $('#stocks_star').find('option:selected').attr('class');
                $('#stars').find('.'+selected_option_id).attr('selected','true');
                $('#stars').attr('name','stars_num');
                $("#stars").removeClass('is-invalid inputId');
                $('#stocks_star').addClass('d-none');
                $('#stocks_star').attr('name','');
                $('#stocks_star-error').remove();
            }
        });
        $('input:radio[name=sales_channel]').change(function() {
            if ( $('#use-sales-channel').prop( "checked") ){
                $('#crm_div').removeClass('d-none');
            } else {
                $('#crm_div').addClass('d-none');
                $('#crm').val('');
            }
        });

        $(".inputId").on("keyup change", function(e) {
            let is_valid = 0;
            if ($('form').find('#type').val() == '' || $('form').find('#name_pyc').val() == ''
                || $('form').find('#name').val() == ''
                || $('form').find('#country').val() == '' || $('form').find('#city').val() == ''
                || $('form').find('#street').val() == ''
                || $('form').find('#zip').val() == '' || $('form').find('#person').val() == ''
                || $('form').find('#phone').val() == '' || $('form').find('#in-from').val() == ''
                || $('form').find('#out-to').val() == '' || $('form').find('#description_pyc').val() == ''
                || $('form').find("#stars").val() == ''
                || $("#name-new-error").length != 0
                || !$('form').find('#terms-conditions').is(':checked')
                || !$('form').find('#certificate').is(':checked')) {
                is_valid = 0;
            } else {
                if($('form').find('#type').hasClass('is-invalid') || $('form').find('#name').hasClass('is-invalid') || $('form').find('#name_pyc').hasClass('is-invalid')
                    || $('form').find('#country').hasClass('is-invalid') || $('form').find('#city').hasClass('is-invalid')
                    || $('form').find('#street').hasClass('is-invalid')
                    || $('form').find('#zip').hasClass('is-invalid') || $('form').find('#person').hasClass('is-invalid')
                    || $('form').find('#phone').hasClass('is-invalid') || $('form').find('#in-from').hasClass('is-invalid')
                    || $('form').find('#out-to').hasClass('is-invalid') || $('form').find('#description_pyc').hasClass('is-invalid')
                    || $('form').find('#stars').hasClass('is-invalid')
                ) {
                    is_valid = 0;
                } else {
                    is_valid = 1;
                }
            }


            if(is_valid == 1) {
                $('form').find('.saveBtn').attr('disabled', false);
            } else {
                $('form').find('.saveBtn').attr('disabled', true);
            }
        });
        $.validator.setDefaults({
            ignore: ''
        });

        $(document).ready(() => {
            // The ymaps.ready() function will be called when
            // all the API components are loaded and the DOM tree is generated.



            $('#ex-multiselect').select2();
            let all_select_lang = document.getElementById('langauges').value;
            all_select_lang=all_select_lang.replace('[','');
            all_select_lang=all_select_lang.replace(']','');
            all_select_lang = all_select_lang.split(',');
            $('#ex-multiselect').val(all_select_lang).trigger('change');

            $('#service-multiselect').select2();
            let all_select_amenity = document.getElementById('amenities').value;
            all_select_amenity=all_select_amenity.replace('[','');
            all_select_amenity=all_select_amenity.replace(']','');
            all_select_amenity = all_select_amenity.split(',');
            $('#service-multiselect').val(all_select_amenity).trigger('change');

            // Jquery Validations
            $(".hotel-form").validate({

                errorClass: 'is-invalid invalid-feedback',
                validClass: 'success is-valid',
                errorElement: 'span',

                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                        regex: /^[0-9\u0041-\u005A\u0061-\u007A\u00AA\u00B5\u00BA\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0370-\u0374\u0376\u0377\u037A-\u037D\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u048A-\u0527\u0531-\u0556\u0559\u0561-\u0587\u05D0-\u05EA\u05F0-\u05F2\u0620-\u064A\u066E\u066F\u0671-\u06D3\u06D5\u06E5\u06E6\u06EE\u06EF\u06FA-\u06FC\u06FF\u0710\u0712-\u072F\u074D-\u07A5\u07B1\u07CA-\u07EA\u07F4\u07F5\u07FA\u0800-\u0815\u081A\u0824\u0828\u0840-\u0858\u08A0\u08A2-\u08AC\u0904-\u0939\u093D\u0950\u0958-\u0961\u0971-\u0977\u0979-\u097F\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BD\u09CE\u09DC\u09DD\u09DF-\u09E1\u09F0\u09F1\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A59-\u0A5C\u0A5E\u0A72-\u0A74\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABD\u0AD0\u0AE0\u0AE1\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3D\u0B5C\u0B5D\u0B5F-\u0B61\u0B71\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BD0\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C33\u0C35-\u0C39\u0C3D\u0C58\u0C59\u0C60\u0C61\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBD\u0CDE\u0CE0\u0CE1\u0CF1\u0CF2\u0D05-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D\u0D4E\u0D60\u0D61\u0D7A-\u0D7F\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0E01-\u0E30\u0E32\u0E33\u0E40-\u0E46\u0E81\u0E82\u0E84\u0E87\u0E88\u0E8A\u0E8D\u0E94-\u0E97\u0E99-\u0E9F\u0EA1-\u0EA3\u0EA5\u0EA7\u0EAA\u0EAB\u0EAD-\u0EB0\u0EB2\u0EB3\u0EBD\u0EC0-\u0EC4\u0EC6\u0EDC-\u0EDF\u0F00\u0F40-\u0F47\u0F49-\u0F6C\u0F88-\u0F8C\u1000-\u102A\u103F\u1050-\u1055\u105A-\u105D\u1061\u1065\u1066\u106E-\u1070\u1075-\u1081\u108E\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u1380-\u138F\u13A0-\u13F4\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u1700-\u170C\u170E-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176C\u176E-\u1770\u1780-\u17B3\u17D7\u17DC\u1820-\u1877\u1880-\u18A8\u18AA\u18B0-\u18F5\u1900-\u191C\u1950-\u196D\u1970-\u1974\u1980-\u19AB\u19C1-\u19C7\u1A00-\u1A16\u1A20-\u1A54\u1AA7\u1B05-\u1B33\u1B45-\u1B4B\u1B83-\u1BA0\u1BAE\u1BAF\u1BBA-\u1BE5\u1C00-\u1C23\u1C4D-\u1C4F\u1C5A-\u1C7D\u1CE9-\u1CEC\u1CEE-\u1CF1\u1CF5\u1CF6\u1D00-\u1DBF\u1E00-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u2071\u207F\u2090-\u209C\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2183\u2184\u2C00-\u2C2E\u2C30-\u2C5E\u2C60-\u2CE4\u2CEB-\u2CEE\u2CF2\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D80-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2E2F\u3005\u3006\u3031-\u3035\u303B\u303C\u3041-\u3096\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312D\u3131-\u318E\u31A0-\u31BA\u31F0-\u31FF\u3400-\u4DB5\u4E00-\u9FCC\uA000-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA61F\uA62A\uA62B\uA640-\uA66E\uA67F-\uA697\uA6A0-\uA6E5\uA717-\uA71F\uA722-\uA788\uA78B-\uA78E\uA790-\uA793\uA7A0-\uA7AA\uA7F8-\uA801\uA803-\uA805\uA807-\uA80A\uA80C-\uA822\uA840-\uA873\uA882-\uA8B3\uA8F2-\uA8F7\uA8FB\uA90A-\uA925\uA930-\uA946\uA960-\uA97C\uA984-\uA9B2\uA9CF\uAA00-\uAA28\uAA40-\uAA42\uAA44-\uAA4B\uAA60-\uAA76\uAA7A\uAA80-\uAAAF\uAAB1\uAAB5\uAAB6\uAAB9-\uAABD\uAAC0\uAAC2\uAADB-\uAADD\uAAE0-\uAAEA\uAAF2-\uAAF4\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uABC0-\uABE2\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D\uFB1F-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE70-\uFE74\uFE76-\uFEFC\uFF21-\uFF3A\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC\s\-\s\_]*$/,
                    },
                    title_pyc: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                        regex: /^[0-9\u0041-\u005A\u0061-\u007A\u00AA\u00B5\u00BA\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0370-\u0374\u0376\u0377\u037A-\u037D\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u048A-\u0527\u0531-\u0556\u0559\u0561-\u0587\u05D0-\u05EA\u05F0-\u05F2\u0620-\u064A\u066E\u066F\u0671-\u06D3\u06D5\u06E5\u06E6\u06EE\u06EF\u06FA-\u06FC\u06FF\u0710\u0712-\u072F\u074D-\u07A5\u07B1\u07CA-\u07EA\u07F4\u07F5\u07FA\u0800-\u0815\u081A\u0824\u0828\u0840-\u0858\u08A0\u08A2-\u08AC\u0904-\u0939\u093D\u0950\u0958-\u0961\u0971-\u0977\u0979-\u097F\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BD\u09CE\u09DC\u09DD\u09DF-\u09E1\u09F0\u09F1\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A59-\u0A5C\u0A5E\u0A72-\u0A74\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABD\u0AD0\u0AE0\u0AE1\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3D\u0B5C\u0B5D\u0B5F-\u0B61\u0B71\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BD0\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C33\u0C35-\u0C39\u0C3D\u0C58\u0C59\u0C60\u0C61\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBD\u0CDE\u0CE0\u0CE1\u0CF1\u0CF2\u0D05-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D\u0D4E\u0D60\u0D61\u0D7A-\u0D7F\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0E01-\u0E30\u0E32\u0E33\u0E40-\u0E46\u0E81\u0E82\u0E84\u0E87\u0E88\u0E8A\u0E8D\u0E94-\u0E97\u0E99-\u0E9F\u0EA1-\u0EA3\u0EA5\u0EA7\u0EAA\u0EAB\u0EAD-\u0EB0\u0EB2\u0EB3\u0EBD\u0EC0-\u0EC4\u0EC6\u0EDC-\u0EDF\u0F00\u0F40-\u0F47\u0F49-\u0F6C\u0F88-\u0F8C\u1000-\u102A\u103F\u1050-\u1055\u105A-\u105D\u1061\u1065\u1066\u106E-\u1070\u1075-\u1081\u108E\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u1380-\u138F\u13A0-\u13F4\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u1700-\u170C\u170E-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176C\u176E-\u1770\u1780-\u17B3\u17D7\u17DC\u1820-\u1877\u1880-\u18A8\u18AA\u18B0-\u18F5\u1900-\u191C\u1950-\u196D\u1970-\u1974\u1980-\u19AB\u19C1-\u19C7\u1A00-\u1A16\u1A20-\u1A54\u1AA7\u1B05-\u1B33\u1B45-\u1B4B\u1B83-\u1BA0\u1BAE\u1BAF\u1BBA-\u1BE5\u1C00-\u1C23\u1C4D-\u1C4F\u1C5A-\u1C7D\u1CE9-\u1CEC\u1CEE-\u1CF1\u1CF5\u1CF6\u1D00-\u1DBF\u1E00-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u2071\u207F\u2090-\u209C\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2183\u2184\u2C00-\u2C2E\u2C30-\u2C5E\u2C60-\u2CE4\u2CEB-\u2CEE\u2CF2\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D80-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2E2F\u3005\u3006\u3031-\u3035\u303B\u303C\u3041-\u3096\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312D\u3131-\u318E\u31A0-\u31BA\u31F0-\u31FF\u3400-\u4DB5\u4E00-\u9FCC\uA000-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA61F\uA62A\uA62B\uA640-\uA66E\uA67F-\uA697\uA6A0-\uA6E5\uA717-\uA71F\uA722-\uA788\uA78B-\uA78E\uA790-\uA793\uA7A0-\uA7AA\uA7F8-\uA801\uA803-\uA805\uA807-\uA80A\uA80C-\uA822\uA840-\uA873\uA882-\uA8B3\uA8F2-\uA8F7\uA8FB\uA90A-\uA925\uA930-\uA946\uA960-\uA97C\uA984-\uA9B2\uA9CF\uAA00-\uAA28\uAA40-\uAA42\uAA44-\uAA4B\uAA60-\uAA76\uAA7A\uAA80-\uAAAF\uAAB1\uAAB5\uAAB6\uAAB9-\uAABD\uAAC0\uAAC2\uAADB-\uAADD\uAAE0-\uAAEA\uAAF2-\uAAF4\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uABC0-\uABE2\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D\uFB1F-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE70-\uFE74\uFE76-\uFEFC\uFF21-\uFF3A\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC\s\-\s\_]*$/,
                    },
                    country: {
                        min: 1
                    },
                    stars_num: {
                        min: 1
                    },
                    type: {
                        min: 1
                    },
                    city: {
                        min: 1
                    },
                    street_house: {
                        required: true,
                    },
                    zip_code: {
                        required: true
                    },
                    description_pyc: {
                        required: true
                    },
                    contact_person: {
                        required: true
                    },
                    agree_terms: {
                        required: true
                    },
                    certify_terms: {
                        required: true
                    },
                    // check_in_from: {
                    //     selectcheck: true
                    // },
                    //
                    // check_out_to: {
                    //     selectcheck: true,
                    //     validHour: true
                    //     // minLength: 1, //validates minimum value the element has to have
                    //     // max:
                    // },
                    phone_number: {
                        validNumber: true,
                        required: true
                    },
                    map: {
                        required: true
                    }
                    // alt_phone: {
                    //     required: true
                    // }
                },

                messages: {
                    map: {
                        required: "Map is required"
                    },
                    name: {
                        required: "Please enter your name",
                        regex: "Please enter a valid name",
                    },
                    description: {
                        required: "Please enter your description"
                    },
                    country: "Country is required",
                    city: "City is required",
                    stars_num: "Stars is required",
                    type: "Type is required",
                    street_house: {
                        required: "Street and Building number is required",
                    },
                    zip_code: {
                        requried: "ZIP Code is required"
                    },
                    phone_number: {
                        required: "Please enter your phone",
                        validNumber: "Please enter valid number"
                    },
                    alt_phone: {
                        required: "Please enter your additional phone"
                    },
                    agree_terms: {
                        required: ''
                    },
                    certify_terms: {
                        required: ''
                    },
                    check_out_to: {
                        validHour: "Check-out-to must be After than Check Out From"
                    },
                    check_in_to: {
                        validHourto: "Check-in-to must be After than CheckIn From"
                    }


                },

                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass(validClass);
                    $(element).parents("div").siblings('label').addClass('is-invalid').removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass(validClass);
                    $(element).parents("div").siblings('label').removeClass('is-invalid').addClass(validClass);
                },

                submitHandler: function(form) {
                    if($.trim($('.each-photo-block').html())!=''){
                        $('.saveBtn').attr('disabled',false);
                        form.submit();
                    } else {
                        $('.saveBtn').attr('disabled',true);
                    }
                }
            });

            $.validator.addMethod("regex", function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            });
            $.validator.addMethod('selectcheck', function(value) {
                return (value != '0');
            }, "This field is required");
            $.validator.addMethod('validNumber', function(value) {
                return iti.isValidNumber(value);
            });
            $.validator.addMethod('validHour', function(value, element, options) {
                let val = moment($("#out-from option:selected").text(), 'HH:mm')
                return moment(value, 'HH:mm').isAfter(val)
            })
            $.validator.addMethod('validHourto', function(value, element, options) {
                let val = moment($("#in-from option:selected").text(), 'HH:mm')
                return moment(value, 'HH:mm').isAfter(val)
            })




            // Select 2
               $("#city").select2({
                minimumInputLength: 2,
                theme: 'bootstrap4',
                width: 'style',
                // tags: false,
                ajax: {
                    url: "{{ route('filter-country')}}",
                    type: "POST",
                    quietMillis: 50,
                    data: function (term) {
                        let parentId = $('#country').val();
                        return {
                            city_name: term, type: 'State',
                            _token:  $('meta[name="csrf-token"]').attr('content'),
                            parent_id: parentId
                        };
                    },
                    processResults: function (res) {
                        return {
                            results: res.data.map(function (item) {
                                console.log(item);
                                return {
                                    text: item.name[locale],
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            function openInput() {
                var checkBox = document.getElementsByClassName("checks");
                var input = document.getElementsByClassName("checksInput");
                for (let i = 0; i < checkBox.length; i++) {
                    if (checkBox[i].checked == true) {
                        input[i].style.display = "flex";
                    } else {
                        input[i].style.display = "none";
                    }
                }
            }

            // Photo book main photo

            // let $radioButtons = $('.radioBtn');
            // $(document).on('click', '.radioBtn', function() {
            //     $radioButtons.each(function() {

            //     });
            // });


            // $(document).on('click', '.radioBtn', function() {
            //     $radioButtons.each(function() {
            //         $(this).parents(".sales-channel-inner-form").toggleClass('active', this.checked);
            //     });
            // });


            // $('.radioBtn').on('click', function() {
            //     $radioButtons.each(function() {
            //         console.log(this)
            //         $(this).parents(".photoFigure").toggleClass('active', this.checked);
            //         $(this).parent().parent().toggleClass('active', this.checked);
            //         console.log($(this).parent().parent().parent().children().eq(1))
            // //     });
            // // });

            // let $radioButtons = $('input[type="radio"]');
            // $radioButtons.click(function() {
            //     $radioButtons.each(function() {

            //         $(this).parents(".photoFigure").toggleClass('active', this.checked);
            //     });
            // });


            // $radioButtons.click(function() {
            //     $radioButtons.each(function() {
            //         $(this).parents(".sales-channel-inner-form").toggleClass('active', this.checked);
            //     });
            // });

            // $radioButtons.click(function() {
            //     $radioButtons.each(function() {
            //         $(this).parent().parent().toggleClass('active', this.checked);
            //         console.log($(this.val()))
            //     });
            // });


            // Dependent Selector
            $("#country").on('change', function() {
                $('#city').val(null).trigger('change');

            })


            // TelInput

            var input = document.querySelector("#phone");
            var iti = intlTelInput(input, {
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return selectedCountryPlaceholder;
                },
                utilsScript: '/js/utils.js',
                preferredCountries: [],
                initialCountry: "am",
                onlyCountries: function (){
                    var isos = $("#countries_codes").val().split(',');
                    return isos;
                }
            })
            $("#country").on("change", function (){
                var x = $('option:selected', this).attr('data-iso');
                iti.setCountry(x);
                // inputs.serCountry(x);
                $("#phone").removeClass('is-invalid');
                $('#phone').val('');
            });
            iti.setNumber('{{$hotel->accommodation->phone}}')

            var telInput = $("#phone")
            // on blur: validate
            telInput.on("change", function() {
                if (phoneNumberValidator(iti, telInput)) {
                    $('input[name=phone]').val(iti.getNumber())
                } else {
                    $('input[name=phone]').val('')
                }
            });

            var input = document.querySelector("#alt_phone");
            var inputs = intlTelInput(input, {
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return selectedCountryPlaceholder;
                },
                utilsScript: '/js/utils.js',
                preferredCountries: [],
                initialCountry: "am",
                onlyCountries: function (){
                    var isos = $("#countries_codes").val().split(',');
                    return isos;
                }

            });
            var x = $('option:selected', $('#country')).attr('data-iso');
            inputs.setCountry(x);

            $("#country").on("change", function (){
                var x = $('option:selected', this).attr('data-iso');
                inputs.setCountry(x);
                $("#alt_phone").removeClass('is-invalid');
                $('#alt_phone').val('');
            });

            inputs.setNumber('{{$hotel->accommodation->alt_phone}}')

            const alt = $("#alt_phone")
            // on blur: validate
            alt.on("change", function() {
                if (phoneNumberValidator(inputs, alt)) {
                    $('input[name=alt_phone]').val(inputs.getNumber())
                } else {
                    $('input[name=alt_phone]').val('')
                }
            });
            // validating phone number based on country
            const phoneNumberValidator = (object, input) => {
                if (object.isValidNumber()) {
                    input.addClass('is-valid')
                    input.removeClass("is-invalid")
                    return true
                }
                if (!object.isValidNumber()) {
                    input.removeClass("is-valid");
                    input.addClass('is-invalid')
                    return false
                }
            }


            $('#pyc_child').on('click', () => (textAreaChanger(`eng_child`, `pyc_child`, 'child_policy', `child_policy_pyc`)))
            $('#eng_child').on('click', () => (textAreaChanger(`pyc_child`, `eng_child`, 'child_policy_pyc', `child_policy`)))

            $('#pyc_desc').on('click', () => (textAreaChanger(`eng_desc`, `pyc_desc`, 'description', `description_pyc`)))
            $('#eng_desc').on('click', () => (textAreaChanger(`pyc_desc`, `eng_desc`, 'description_pyc', `description`)))


            $(`#eng_rule`).on('click', () => (textAreaChanger(`pyc_rule`, `eng_rule`, 'other_rules_pyc', `other_rules`)))
            $(`#pyc_rule`).on('click', () => (textAreaChanger(`eng_rule`, `pyc_rule`, `other_rules`, 'other_rules_pyc')))

            $('#pyc_name').on('click', () => (textAreaChanger(`eng_name`, `pyc_name`, 'name', `name_pyc`)))
            $('#eng_name').on('click', () => (textAreaChanger(`pyc_name`, `eng_name`, 'name_pyc', `name`)))

            let textAreaChanger = (from_btn, to_btn, from_id, to_id) => {
                $(`#${from_btn}`).removeClass('active')
                $(`#${to_btn}`).addClass('active')
                $(`#${from_id}`).hide()
                $(`#${to_id}`).show()
            }

            $(".deleteRoom").on('click', function(e) {
                let url = $(this).data("url");
                console.log(url);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type: "DELETE",
                    success: function(response) {
                        $(`#${response.id}`).remove();
                    }
                });
            })


        })
        ("#states").select2({
            minimumInputLength: 2,
            theme: 'bootstrap4',
            width: 'style',
            // tags: false,
            ajax: {
                url: "/locations/search",
                dataType: 'json',
                type: "post",
                quietMillis: 50,
                data: function (term) {
                    let parentId = $('#countries').val();
                    console.log(parentId);
                    return {
                        data: term, type: 'State',
                        _token: _token,
                        parent_id: parentId
                    };
                },
                processResults: function (res) {
                    return {
                        results: res.map(function (item) {
                            return {
                                text: item.name_en,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    </script>
    <x-validator />
    <x-file-upload />
@endsection
