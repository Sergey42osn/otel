<section class="conditions-section">
    <div class="title-part">
        <h2>@lang('accommodation.accommodationConditions')</h2>
    </div>
    <div class="condition-box-body">
        <div class="condition-box-row flex-column flex-md-row">
            <h3>@lang('accommodation.checkIn')</h3>
            <div>
                <span>{{$accommodation->check_ins->from ?? null}}</span>
            </div>
        </div>
        <div class="condition-box-row flex-column flex-md-row">
            <h3>@lang('accommodation.checkOut')</h3>
            <div>
                <span>{{(isset($accommodation->check_outs) && isset($accommodation->check_outs[0])) ? $accommodation->check_outs[0]->to : ''}}</span>
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
                    <span style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis; overflow: hidden" id="condition_content">{{$accommodation->other_rules}}</span>
                </div>
                    <div class="condition-box-text hotel-other-rules">
                        @if(!$accommodation->allow_child)
                            <span style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis; overflow: hidden" id="condition_content">{{__('accommodation.noChildren')}}</span>
                        @else
                            <span style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis; overflow: hidden" id="condition_content">{{__('accommodation.children')}}</span>
                        @endif
                    </div>
                    @if(isset($accommodation->child_policy))
                        <div class="condition-box-text hotel-other-rules">
                            <span style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis; overflow: hidden" id="condition_content">{{$accommodation->child_policy}}</span>
                        </div>
                    @endif
                    <div class="condition-box-text hotel-other-rules">
                        @if($accommodation->allow_pets==0)
                            <span style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis; overflow: hidden" id="condition_content">{{__('accommodation.noPets')}}</span>
                        @else
                            <span style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis; overflow: hidden" id="condition_content">{{__('accommodation.pets')}}</span>
                        @endif
                    </div>
                <span style="display: none;" id="learn_more" class="learn-more learn-more-rules">@lang('accommodation.learnMore')</span>
                <span style="display: none;" id="show_less" class="learn-more learn-more-rules">@lang('accommodation.showLess')</span>
            </div>
        </div>
    </div>
</section>
