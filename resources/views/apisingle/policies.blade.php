<section class="conditions-section">
    <div class="title-part">
        <h2>@lang('accommodation.accommodationConditions')</h2>
    </div>
    <div class="condition-box-body">
        <div class="condition-box-row flex-column flex-md-row">
            <h3>@lang('accommodation.checkIn')</h3>
            <div>
                <span>{{$info_hotel_search['info']->check_in_time ?? null}}</span>
            </div>
        </div>
        <div class="condition-box-row flex-column flex-md-row">
            <h3>@lang('accommodation.checkOut')</h3>
            <div>
                <span>{{$info_hotel_search['info']->check_out_time ? $info_hotel_search['info']->check_out_time : ''}}</span>
            </div>
        </div>
        <div class="condition-box-row flex-column flex-md-row">
            <h3>@lang('accommodation.hotelRules')</h3>
            <div>
{{--                @foreach($accommodation->policies as $policy)--}}
{{--                    <div class="condition-box-text">--}}
{{--                        <p>{{$policy->name}}</p>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
                <div class="condition-box-text hotel-other-rules">
                    @foreach($info_hotel_search['info']->policy_struct as $r)
                        @if($r->paragraphs[0] != '')
                        <span style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis; overflow: hidden" id="condition_content">{{$r->paragraphs[0]}}</span>
                        @endif
                    @endforeach
                </div>
                <span style="display: none;" id="learn_more" class="learn-more learn-more-rules">@lang('accommodation.learnMore')</span>
                <span style="display: none;" id="show_less" class="learn-more learn-more-rules">@lang('accommodation.showLess')</span>
            </div>
        </div>
    </div>
</section>
