@php
    $accommodation_id = request()->has('hotelId') ? request()->input('hotelId') : ($accommodation->id ? $accommodation->id : '' );
    $rooms_count = request()->has('roomCount') ? request()->input('roomCount') : 1;
    $adult_count = request()->has('adults') ? request()->input('adults') : 2;
    $id = isset($room->id) ? $room->id : '';
    $room_id = isset($room->id) ? $room->id : '';
    $room_id_from_api = isset($room->code_from_api) ? $room->code_from_api : '';
    $type = $room->type;
    $room_size = $room->size;
    $accommodation_type = is_array($accommodation) ? 'hotel' : $accommodation->type;
    if( in_array($accommodation_type, ['hotel', 'youth_hotel']) ) {
        $name = ($room->name()->first() != null) ? $room->name()->first()->name : '';
        $url_room = '&room='.$id;
        $beds['single_bed'] = $room->single_bed;
        $beds['double_bed'] = $room->double_bed;
        $beds['sofa_bed'] = $room->sofa_bed;
        $beds['wide_bed'] = $room->wide_bed;
        $beds['futon'] = $room->futon;
        $beds['additional_bed'] = !is_null($room->extra_beds) ? $room->extra_beds : 0;
        $guest_count = $room->guest_count;
        $travel_line_info_arr = isset($available_room_info) ? $available_room_info : [];

    $params = [];
    $cancelArr = [];
    $cancel_message1=$cancel_message2=$cancel1_info=$cancel2_info="";
    $availability = '';
        if( $room_id_from_api != '' && !empty($travel_line_info_arr) ) {
            if(array_key_exists($room_id_from_api, $travel_line_info_arr)) {
                $travel_line_room_info = $travel_line_info_arr[$room_id_from_api][$room->api_plane_id];
                if( array_key_exists('price', $travel_line_room_info) ) {
                    if(isset($travel_line_room_info['price']) && $travel_line_room_info['price'] > 0) {
                        $price_var = $travel_line_room_info['price'];
                        foreach ($travel_line_room_info['cancellationPolicy'] as $item) {
                            array_push($cancelArr, $item);
                        }
                         $availability = $travel_line_room_info['availability'];
                    }
                }
            }
        }
    } else {
        $name = isset($room->title) ? $room->title : '';
        $url_room = '&accommodation='.$accommodation_id;
    }
    $images = $room->images;
    switch($accommodation_type) {
        case 'villa':
        case 'appartment':
            $imagesVar = $functional_image = $accommodation->appartment()->images;
            $images[0] = $imagesVar->first(function($image) {
                return $image->featured_image == 1 && $image->url;
            });
        break;
    }
    $services = method_exists($room, 'roomServicesSelected') ? $room->roomServicesSelected() : [];
    $services_names = method_exists($room, 'roomServicesSelectedName') ? $room->roomServicesSelectedName() : [];
    $amenities = $room->amenities;
    $number = $room->number;
    $description = (isset($room['description']) && $room['description'] != '') ? $room['description'] : '';
    $storage = '/storage/uploads/';
    $child_count = request()->has('children') ? request()->input('children') : 0;
    $period = request()->has('datefilter') ? request()->input('datefilter') : '';
    if( $period != '' ) {
        $dates = explode('-', $period);
        if( count($dates) > 1 ) {
            $check_in = $dates[0];
            $check_out = $dates[1];
        }
    }
    if( !isset($check_in) && !isset($check_out) ) {
        $check_in = request()->has('check_in') ? \Illuminate\Support\Carbon::createFromFormat('m/d/Y', request()->input('check_in')) ->format('m/d/Y') : \Illuminate\Support\Carbon::today()->format('m/d/Y');
        $check_out = request()->has('check_out') ? \Illuminate\Support\Carbon::createFromFormat('m/d/Y', request()->input('check_out')) ->format('m/d/Y') : \Illuminate\Support\Carbon::tomorrow()->format('m/d/Y');
    }
    $carbonIn = \Illuminate\Support\Carbon::createFromFormat('m/d/Y', $check_in);
    $carbonOut = \Illuminate\Support\Carbon::createFromFormat('m/d/Y', $check_out);
    $date_diff = $carbonIn->diffInDays($carbonOut);
    $price = isset($price_var) ? $price_var : $date_diff * $room->price;


    if(!empty($cancelArr) && $cancelArr[0]==true) {
        if(!str_contains($room->roomable->accommodation->city->tz_offset, '-')){
           $plus_minus = '+';
        } else {
            $plus_minus = '';
        }
        $time = strtotime($cancelArr[1]);

        $newformat = date('d/m/Y H:i',$time);
        $cancel1_info = $newformat;
        $cancel2_info = $cancelArr[3];
        $cancel_message1 = __('rooms.cancel_until')." <br>".$cancel1_info." GMT ".$plus_minus." ".$room->roomable->accommodation->city->tz_offset."<br> ".__('rooms.withoutPenalty');
        $cancel_message2= __('rooms.penaltyAmount')." ".$cancelArr[3]." ".__('rooms.rub');
    }
    if(!empty($cancelArr) && $cancelArr[0]==false) {
        $cancel2_info = $cancelArr[3];
        $cancel_message1= __('rooms.newpenaltyAmount')." ".$cancelArr[3]." ".__('rooms.rub');

    }
    if($adult_count > 0 && $rooms_count > 0 && $accommodation_id != '' && $id != '') {
        $params['adults'] = $adult_count;
        $params['children'] = $child_count;
        $params['rooms'] = $rooms_count;
        $params['check_in'] = $check_in;
        $params['check_out'] = $check_out;
        $params['price'] = $price;

        if( isset($child_ages) && count($child_ages) > 0 ) {
            foreach($child_ages as $key => $child_age) {
                $params['child_age_'.$key] = $child_age;
            }
        }
        if(isset($travel_line_room_info)) {
            if(is_array($travel_line_room_info)) {
                if(isset($travel_line_room_info['placement_code'])) {$params['placement_code'] = $travel_line_room_info['placement_code'];}
                if(isset($travel_line_room_info['check_sum'])) {$params['check_sum'] = $travel_line_room_info['check_sum'];}
            }
        }
        $params['rate_plan_id'] = $room->api_plane_id;
        $urlParams = http_build_query($params);
        $url = '/'.App::getLocale().'/order?'.$urlParams.$url_room.'&cancel1='.$cancel1_info.'&cancel2='.$cancel2_info.'&availability='.$availability.'&room_count=1';
    }


@endphp

<div class="d-flex table-body flex-column flex-md-row room_acc">
    <div class="table-column">
        <input type="hidden" value="{{$room_id}}" class="room_id">
        <div class="d-flex" style="position: relative;align-items: center">
            @php  $image_head = '';
                foreach ($images as $image){
                    if ($image->featured_image=='1'){
                        $image_head = $image->url;
                    }
                }
            @endphp
            @if(!empty($images) && count($images) > 0)
                @if($image_head!='')
                    <figure>
                        <a data-fancybox="gallery{{$room_id}}" href="{{$storage.$image_head}}">
                            <img src="{{$storage.$image_head}}" />
                            <span style="position: absolute;color:#000;top: 5%;
                                        font-size: 13px;
                                        padding-left: 8px;
                                        font-weight: 600;"
                            >{{$name}}{{$room->api_plane_id ? ' - '.$rate_plans[$room->api_plane_id] : ''}}</span>

                        </a>
                    </figure>
                    @foreach($images as $image)
                        @if($image->featured_image!='1')
                            <figure class="d-none">
                                <a data-fancybox="gallery{{$room_id}}" href="{{$storage.$image->url}}">
                                    <img src="{{$storage.$image->url}}" />
                                </a>
                            </figure>
                        @endif
                    @endforeach
                @else
                    @foreach($images as $image)
                        @if($loop->index==0)
                            <figure>
                                <a data-fancybox="gallery{{$room_id}}" href="{{$storage.$image->url}}">
                                    <img src="{{$storage.$image->url}}" />
                                    <span style="position: absolute;color:#000;top: 5%;
                                        font-size: 13px;
                                        padding-left: 8px;
                                        font-weight: 600;"
                                    >{{$name}}{{$room->api_plane_id ? ' - '.$rate_plans[$room->api_plane_id] : ''}}</span>
                                </a>
                            </figure>
                        @else
                            <figure class="d-none">
                                <a data-fancybox="gallery{{$room_id}}" href="{{$storage.$image->url}}">
                                    <img src="{{$storage.$image->url}}" />
                                </a>
                            </figure>
                        @endif
                    @endforeach
                @endif
            @else
                <h3>{{$name}}{{$room->api_plane_id ? ' - '.$rate_plans[$room->api_plane_id] : ''}}</h3>
            @endif
        </div>
        <div class="table-text-box">
            <p>{{$description}}</p>
            @if(isset($beds) && count($beds) > 0)
                @foreach($beds as $bed_type => $bed_count)
                    @if($bed_count > 0)
                        <p>{{$bed_count.' '.__('rooms.beds.'.$bed_type)}}</p>
                    @endif
                @endforeach
            @endif
            @if($amenities)
                <ul>
                    @foreach($amenities as $amenity)
                        <li class="{{$amenity->icon}}} list-item">{{$amenity->name}}</li>
                    @endforeach
                </ul>
            @endif
{{--            @if(isset($guest_count) && $guest_count > 0)--}}
{{--                <p>{{__('rooms.beds.guest_count').' - '. $guest_count}}</p>--}}
{{--            @endif--}}
            @if(isset($room_size))
                <p>{!! __('rooms.room_size_title').' - '. $room_size." ".__('rooms.m2') !!}</p>
            @endif

            @if($room->prepayment)
                <p>{{__('rooms.prepayment_single')}}</p>
            @endif

            <p>{!! $cancel_message1!!}</p>
            <p>{!! $cancel_message2!!}</p>
        </div>
    </div>
    <div class="table-column">
        <span class="d-block d-md-none">@lang('accommodation.priceFor') {{$date_diff}} {{trans_choice('accommodation.nights', $date_diff) }}</span>
        <span class="price">{{number_format($price, 0, '.', ' ')}} @lang('rooms.currency')</span>
    </div>
    <div class="table-column">
        <span class="d-block d-md-none">Food</span>
        @if(!empty($services) && count($services) > 0)
            @foreach($services as $key => $service)
                <span class="food-item {{$service->icon}} {{$service->price ? 'included' : ''}}">{{$services_names[$key]->name}} {{$service->price ? '- ' . $service->price.' Rub' : __('accommodation.included')}}
                <br>
            @endforeach

        @endif
    </div>
    <div class="table-column">
        <span class="d-block d-md-none">@lang('accommodation.pleaseChoose')</span>
        @if(!empty($availability))
            <select class="selectRoomCount" name="count_room">
                @for($i = 1; $i <= min([$availability, $adult_count]); $i++)
                    <option {{$i==0 ? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        @endif

    </div>
    <div class="table-column">
        @auth
            @if(isset($url) && Auth::user()->role_id == 2)
                <a href="{{$url}}"  class="btn-blue book-now">@lang('booking.book_now')</a>
            @endif
        @else
            <a data-bs-toggle="modal" data-bs-target="#loginModal" class="btn-blue">@lang('booking.book_now')</a>
        @endauth
    </div>
</div>


<script>
    let x = $('.room_id').val();
    Fancybox.bind('[data-fancybox="gallery'+x+'"]', {

    });

</script>
