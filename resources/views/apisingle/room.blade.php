@php
    
    $images = $room_images;


@endphp

<div class="d-flex table-body flex-column flex-md-row room_acc">
    <div class="table-column">
        <input type="hidden" value="{{$room->book_hash}}" class="room_b">
        <input type="hidden" value="{{$room->match_hash}}" class="room_m">
        <div class="d-flex" style="position: relative;align-items: center">
            @if(!empty($images))
                @if($images)
                    <figure>
                        <a data-fancybox="gallery{{$k_r}}" href="{{ str_replace('{size}','1024x768', $images[0]) }}">
                            <img src="{{ str_replace('{size}','x220', $images[0]) }}" />
                            <span style="position: absolute;color:#000;top: 5%;
                                        font-size: 13px;
                                        padding-left: 8px;
                                        font-weight: 600;"
                            >{{$room->room_name}}</span>

                        </a>
                    </figure>
                    @foreach($images as $image)
                        @if($image !='1')
                            <figure class="d-none">
                                <a data-fancybox="gallery{{$k_r}}" href="{{ str_replace('{size}','1024x768', $image) }}">
                                    <img src="{{ str_replace('{size}','x220', $image) }}" />
                                </a>
                            </figure>
                        @endif
                    @endforeach
                @else
                    @foreach($images as $image)
                        @if($loop->index==0)
                            <figure>
                                <a data-fancybox="gallery{{$k_r}}" href="{{ str_replace('{size}','1024x768', $image) }}">
                                    <img src="{{ str_replace('{size}','220', $image) }}" />
                                    <span style="position: absolute;color:#000;top: 5%;
                                        font-size: 13px;
                                        padding-left: 8px;
                                        font-weight: 600;"
                                    >{{$room->room_name}}</span>
                                </a>
                            </figure>
                        @else
                            <figure class="d-none">
                                <a data-fancybox="gallery{{$k_r}}" href="{{ str_replace('{size}','1024x768', $image) }}">
                                    <img src="{{ str_replace('{size}','220', $image) }}" />
                                </a>
                            </figure>
                        @endif
                    @endforeach
                @endif
            @else
                <h3>{{$room->room_name}}</h3>
            @endif
        </div>
        <div class="table-text-box">
           
            @if($room->amenities_data)
                <ul>
                    @foreach($room->amenities_data as $amenity)
                        <li class="list-item">{{$amenity}}</li>
                    @endforeach
                </ul>
            @endif
                {{--            @if(isset($guest_count) && $guest_count > 0)--}}
                {{--                <p>{{__('rooms.beds.guest_count').' - '. $guest_count}}</p>--}}
                {{--            @endif--}}
            @if(isset($room_size))
                <p>{!! __('rooms.room_size_title').' - '. $room_size." ".__('rooms.m2') !!}</p>
            @endif

            @if(isset($room->prepayment))
                <p>{{__('rooms.prepayment_single')}}</p>
            @endif

            <p></p>
            <p></p>
        </div>
    </div>
    <div class="table-column">
        <span class="d-block d-md-none">@lang('accommodation.priceFor')</span>
        <span class="price">{{number_format($room->daily_prices[0]*$info['night_count'], 0, '.', ' ')}} @lang('rooms.currency')</span>
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
