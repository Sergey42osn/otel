@php
    $child_max_age = 10;
    $roomCount = isset(request()->all()['rooms']) ? request()->all()['rooms'] : old('rooms', '1');
    $adultCount = isset(request()->all()['adults']) ? request()->all()['adults'] : old('adults', '2');
    $childCount = isset(request()->all()['children']) ? request()->all()['children'] : old('children', '0');
    $check_in_date = isset(request()->all()['check_in']) ? request()->all()['check_in'] : \Carbon\Carbon::today()->format('m/d/Y');
    $check_out_date = isset(request()->all()['check_out']) ? request()->all()['check_out'] : \Carbon\Carbon::tomorrow()->format('m/d/Y');
    $childText = $childCount > 0 ? ' - '.$childCount . ' ' .trans_choice('filter.child', $childCount) : '';
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

<div class="availabilty-block">
    <div class="d-flex justify-content-between flex-column flex-lg-row">
        <div id="calendar-input-box" class="calendar-input-box">
            <input type="text" id="datefilter" name="datefilter" data-id="{{$id}}" class="datefilter" value="{{$check_in_date}}-{{$check_out_date}}" readonly/>
            <input type="hidden"  name="check_in" value=""  id="check_in">
            <input type="hidden"  name="check_out" value=""  id="check_out">
            <div>
                <span class="check_in" data-id="{{$id}}" name="check-in">{{ $checkInDateText }}</span>
            </div>
            <div>
                <span class="check_out" data-id="{{$id}}" name="check-out">{{ $checkOutDateText }}</span>
            </div>
        </div>
        <input type="hidden" value="{{$accommodation->accommodationable->id}}" name="hotelId" data-id="{{$id}}" class="hotelId">
        <input type="hidden" value="{{$accommodation->id}}" name="accId" data-id="{{$id}}" class="accId">

        <div class="people-input-box">
{{--{{$roomCount}} {{trans_choice('filter.rooms', $roomCount)}} - --}}
            <input class="selectorBox" data-id="{{$id}}" data-status="closed" type="text" name="" value="{{$adultCount}} {{trans_choice('filter.adult', $adultCount)}}{{$childText}} " readonly/>
            <input type="hidden" data-id="{{$id}}" class="hiddenRoomCount" name="roomCount" value="{{$roomCount}}">
            <input type="hidden" data-id="{{$id}}" class="hiddenAdultCount" name="roomCount" value="{{$adultCount}}">
            <input type="hidden" data-id="{{$id}}" class="hiddenChildCount" name="roomCount" value="{{$childCount}}">
            <div id="selectorBoxArea" data-id="{{$id}}" class="selectorBoxArea people-input-box-opening-block">
                <div class="person-row d-flex justify-content-between d-none">
                    <p class="person-input-title">@lang('accommodation.room')</p>
                    <div class="d-flex align-items-center minus-plus-box">
                        <button type="button" class="minus roomMinus">
                            <minus>-</minus>
                        </button>
                        <span class="roomCount">{{ $roomCount }}</span>
                        <button type="button" class="plus roomPlus">
                            <span>+</span>
                        </button>
                    </div>
                </div>
                <div class="person-row d-flex justify-content-between">
                    <p class="person-input-title">@lang('accommodation.adult')</p>
                    <div class="d-flex align-items-center minus-plus-box">
                        <button type="button" class="minus adultMinus">
                            <minus>-</minus>
                        </button>
                        <span class="adultCount">{{ $adultCount }}</span>
                        <button type="button" class="plus adultPlus">
                            <span>+</span>
                        </button>
                    </div>
                </div>
                <div class="person-row d-flex justify-content-between">
                    <p class="person-input-title">@lang('accommodation.child')</p>
                    <div class="d-flex align-items-center minus-plus-box">
                        <button class="minus childMinus" type="button">
                            <minus>-</minus>
                        </button>
                        <span class="childCount">{{ $childCount }}</span>
                        <button class="plus childPlus" type="button">
                            <span>+</span>
                        </button>
                    </div>
                </div>
                <div class="person-row flex-wrap child-ages d-flex justify-content-between">
                    @if($childCount > 0)
                        @for($i = 1; $i <= $childCount; $i++)
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
        <div>
            <button class="btn-blue checkAvailability" data-id="{{$id}}" >@lang('accommodation.checkAvailability')</button>
        </div>
    </div>
</div>

@section('scripts')
<script>
    let roomCountVar = '{{$roomCount}}';
    let adultCountVar = '{{$adultCount}}';
    let childCountVar = '{{$childCount}}';
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
