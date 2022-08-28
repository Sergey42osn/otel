@php
    $child_max_age = 10;
    $room_count = request()->all()['rooms'] ?? old('rooms', '1');
    $adult_count = request()->all()['adults'] ?? old('adults', '1');
    $child_count = request()->all()['children'] ?? old('children', '0');
    $check_in_date = request()->all()['check_in'] ?? old('check_in', \Carbon\Carbon::today()->format('m/d/Y'));
    $check_out_date = request()->all()['check_out'] ?? old('check_out', \Carbon\Carbon::tomorrow()->format('m/d/Y'));
    $id = isset($data['id']) ? $data['id'] : 1;

    $weekDayNames = [
                __('accommodation.su'),
                __('accommodation.mo'),
                __('accommodation.tu'),
                __('accommodation.we'),
                __('accommodation.th'),
                __('accommodation.fr'),
                __('accommodation.sa'),
            ];
    $check_in = \Carbon\Carbon::createFromFormat('m/d/Y',$check_in_date);
    $check_out = \Carbon\Carbon::createFromFormat('m/d/Y', $check_out_date);
    $check_in_day_num = $check_in->dayOfWeek;
    $check_out_day_num = $check_out->dayOfWeek;
    $check_in_day = $check_in->day;
    $check_out_day = $check_out->day;
    $check_in_month = $check_in->monthName;
    $check_out_month = $check_out->monthName;
    $check_in_year = $check_in->year;
    $check_out_year = $check_out->year;
    $checkInDateText = $weekDayNames[$check_in_day_num].', '.$check_in_day.' '.$check_in_month;
    $checkOutDateText = $weekDayNames[$check_out_day_num].', '.$check_out_day.' '.$check_out_month;
    $checkInDate = $weekDayNames[$check_in_day_num].', '.$check_in_day.' '.$check_in_month.' '.$check_in_year;
    $checkOutDate = $weekDayNames[$check_out_day_num].', '.$check_out_day.' '.$check_out_month.' '.$check_out_year;
@endphp

@section('header_styles')
@endsection

<form action="{{route('search', ['locale' => App::getLocale()])}}" id="search-form" class="single-search-form">
    <h2>{{__('filter.search')}}</h2>
    <label for="place">{{__('filter.place')}}</label>
    <div class="place-input-box position-relative">
        <input value="{{ !empty(request()->all()['place_name']) && !empty(request()->all()['place_id']) ? request()->all()['place_name'] : old('place_name', '') }}" name="place_name" id="place_name" type="text" autocomplete="off">
        <div class="validation-text">
            <p>чтобы начать поиск введите направление</p>
        </div>
        <input value="{{ request()->all()['place_id'] ?? old('place_id', '') }}" name="place_id" id="place_id" type="hidden">
        <input value="{{ request()->all()['place_type'] ?? old('place_type', '') }}" name="place_type" id="place_type" type="hidden">
        <div id="placersContainer">

        </div>
    </div>
    <label>{{__('filter.check_in')}}</label>
    <div class="single-calendar-input-box d-none d-md-block">
        <div>
            <input readonly type="text" value="{{ $checkInDateText }}" class="check_in datefilter" data-type="search" data-id="{{$id}}" id="check_in">
            <input readonly type="hidden" name="check_in" value="{{ $check_in_date }}" class="check_in_hidden" data-type="search" data-id="{{$id}}">
            <i class="chev"></i>
        </div>
        <label>{{__('filter.check_out')}}</label>
        <div>
            <input readonly type="text" value="{{ $checkOutDateText }}" class="check_out datefilter" data-type="search" data-id="{{$id}}" id="check_out">
            <input readonly type="hidden" name="check_out" value="{{ $check_out_date }}" class="check_out_hidden" data-type="search" data-id="{{$id}}">
            <i class="chev"></i>
        </div>
    </div>
    <div class="calendar-input-box d-flex d-md-none">
        <input type="text" id="datefilter" data-id="{{$id}}" class="datefilter" data-type="search" value="{{$check_in_date}}-{{$check_out_date}}" readonly="">
        <div>
            <span class="check-in-text">{{$checkInDateText}}</span>
        </div>
        <div>
            <span class="check-out-text">{{$checkOutDateText}}</span>
        </div>
        <i class="chev"></i>
    </div>
    <label for="rooms">{{ trans_choice('filter.rooms', 2) }}</label>
    <div id="guest-box" data-id="{{$id}}" class="people-input-outer-box guest-box">

        <div class="people-input-box">
            <div class="coll">
                <details>
                    <input name="rooms" data-id="{{$id}}" class="hiddenRoomCount" id="hiddenRoomCount" value="{{ $room_count }}" type="hidden">
                    <input name="adults" data-id="{{$id}}" class="hiddenAdultCount" id="hiddenAdultCount" value="{{ $adult_count }}" type="hidden">
                    <input name="children" data-id="{{$id}}" class="hiddenChildCount" id="hiddenChildCount" value="{{ $child_count }}" type="hidden">
                    <summary data-id="{{$id}}" data-type="search" class="selectorBox" id="selectorBox" data-status="closed">
                        <p> {{ $adult_count }} {{ trans_choice('filter.adult', $adult_count) }} - {{ $child_count }} {{ trans_choice('filter.child', $child_count) }}  </p>
{{--                        {{ $room_count }} {{ trans_choice('filter.rooms', $room_count) }} - --}}
                        <i class="chev"></i>
                    </summary>
                </details>
                <div class="animate">
                    <div data-id="{{$id}}" class="people-input-box-opening-block selectorBoxArea">
                        <div class="person-row d-flex justify-content-between d-none">
                            <p class="person-input-title">{{trans_choice('filter.rooms', $room_count)}}</p>
                            <div class="d-flex align-items-center minus-plus-box">
                                <button id="roomMinus" data-id="{{$id}}" class="minus roomMinus" type="button">
                                    <span></span>
                                </button>
                                <span id="roomCount" data-id="{{$id}}" class="roomCount" >{{ request()->all()['rooms'] ?? old('rooms', '1') }}</span>
                                <button id="roomPlus" data-id="{{$id}}" class="plus roomPlus" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g transform="translate(-747 -1896.75)"><rect width="16" height="1.5" transform="translate(747 1904)" fill="#2475eb"/><rect width="16" height="1.5" transform="translate(755.75 1896.75) rotate(90)" fill="#2475eb"/></g></svg>
                                </button>
                            </div>
                        </div>
                        <div class="person-row d-flex justify-content-between">
                            <p class="person-input-title">{{trans_choice('filter.adult', $adult_count)}}</p>
                            <div class="d-flex align-items-center minus-plus-box">
                                <button id="adultMinus" data-id="{{$id}}" class="minus adultMinus" type="button">
                                    <span></span>
                                </button>
                                <span id="adultCount" data-id="{{$id}}" class="adultCount" >{{ request()->all()['adults'] ?? old('adults', '1') }}</span>
                                <button  id="adultPlus" data-id="{{$id}}" class="plus adultPlus" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g transform="translate(-747 -1896.75)"><rect width="16" height="1.5" transform="translate(747 1904)" fill="#2475eb"/><rect width="16" height="1.5" transform="translate(755.75 1896.75) rotate(90)" fill="#2475eb"/></g></svg>
                                </button>
                            </div>
                        </div>
                        <div class="person-row d-flex justify-content-between">
                            <p class="person-input-title">{{trans_choice('filter.child', $adult_count)}}</p>
                            <div class="d-flex align-items-center minus-plus-box">
                                <button id="childMinus" data-id="{{$id}}" class="minus childMinus" type="button">
                                    <span></span>
                                </button>
                                <span id="childCount" data-id="{{$id}}" class="childCount" >{{ request()->all()['children'] ?? old('children', '0') }}</span>
                                <button id="childPlus" data-id="{{$id}}" class="plus childPlus" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><g transform="translate(-747 -1896.75)"><rect width="16" height="1.5" transform="translate(747 1904)" fill="#2475eb"/><rect width="16" height="1.5" transform="translate(755.75 1896.75) rotate(90)" fill="#2475eb"/></g></svg>
                                </button>
                            </div>
                        </div>
                        <div class="person-row flex-wrap child-ages d-flex justify-content-between">
                            @if($child_count > 0)
                                @for($i = 1; $i <= $child_count; $i++)
                                    @php
                                        $req_child_age = request()->input('child_age_'.$i);
                                        $child_age = (isset($req_child_age) && $req_child_age > 0) ? $req_child_age : 1;
                                    @endphp
                                    <select required style="font-size: 12px" class='mt-2 col-6 child-age-select' name='child_age_{{$i}}'>
                                        <option disabled>@lang('accommodation.age_need')</option>
                                        @for($j = 1; $j <= $child_max_age; $j++)
                                            <option {{$child_age == $j ? 'selected' : ''}} value="{{$j}}">{{$j}}</option>
                                        @endfor
                                    </select>
                                @endfor
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="search-btn btn-blue">{{__('filter.search')}}</button>
</form>
@section("footer_scripts")
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        let roomCountVar = '{{$room_count}}';
        let adultCountVar = '{{$adult_count}}';
        let childCountVar = '{{$child_count}}';
        let checkInDate = '{{$check_in_date}}';
        let checkOutDate = '{{$check_out_date}}';

        let datePickerLocale = {
            cancelLabel: '',
            applyLabel: '{{__("home.apply")}}',
            format: 'MM/DD/YYYY',
            "daysOfWeek": [
                "{{__('accommodation.su')}}",
                "{{__('accommodation.mo')}}",
                "{{__('accommodation.tu')}}",
                "{{__('accommodation.we')}}",
                "{{__('accommodation.th')}}",
                "{{__('accommodation.fr')}}",
                "{{__('accommodation.sa')}}",
            ],
            "monthNames": [
                "{{__('accommodation.january')}}",
                "{{__('accommodation.february')}}",
                "{{__('accommodation.march')}}",
                "{{__('accommodation.april')}}",
                "{{__('accommodation.may')}}",
                "{{__('accommodation.june')}}",
                "{{__('accommodation.july')}}",
                "{{__('accommodation.august')}}",
                "{{__('accommodation.september')}}",
                "{{__('accommodation.october')}}",
                "{{__('accommodation.november')}}",
                "{{__('accommodation.december')}}",
            ],
            "firstDay": 1
        }
    </script>
@stop



