@extends("layouts.account")
@section('title', __('account.booking-history'))

@section('contents')
    <section class="banner-section">
        <div class="banner-part" style="background-image:url('{{ asset("images/chris-karidis-QXW1YEMhq_4-unsplash.png")}}')"></div>
    </section>
    <section class="category-section">
        <div class="container">
            <div id="booking-history-page">
                <div class="container">
                    <div class="d-flex flex-column flex-md-row partial-block">
                        @include('account.sidebar')
                        <section class="large">
                            <div class="title-part">
                                <h1>{{__('hotel.booking_history.booking_history')}}</h1>
                            </div>
                            <select name="name" id="object_type" class="object-type mt-5 mb-5" >
                                <option value="" {{isset($_GET['type']) && $_GET['type']==""? 'selected': ' '}}>{{__('vendor.all_objects')}}</option>
                                <option value="hotel" {{isset($_GET['type']) && $_GET['type']=="hotel"? 'selected': ' '}}>{{__('vendor.hotel')}}</option>
                                <option value="apartment" {{isset($_GET['type']) && $_GET['type']=="apartment"? 'selected': ' '}}>{{__('vendor.apartment')}}</option>
                                <option value="youth_hotel" {{isset($_GET['type']) && $_GET['type']=="youth_hotel"? 'selected': ' '}}>{{__('vendor.youth_hotel')}}</option>
                                <option value="villa" {{isset($_GET['type']) && $_GET['type']=="villa"? 'selected': ' '}}>{{__('vendor.villa')}}</option>
                            </select>
                            <div class="table-block object-table">
                                <div class="table-header">
                                    <div class="table-row">
                                        <div class="type-td">
                                            <span>{{__('hotel.booking_history.type')}}</span>
                                        </div>
                                        <div class="name-td">
                                            <span>{{__('hotel.booking_history.name')}}</span>
                                        </div>
                                        <div class="date-td">
                                            <span>{{__('hotel.booking_history.date')}}</span>
                                        </div>
                                        <div class="time-td">
                                            <span>{{__('hotel.booking_history.time')}}</span>
                                        </div>
                                        <div class="price-td">
                                            <span>{{__('hotel.booking_history.price')}}</span>
                                        </div>
                                        <div class="status-td">
                                            <span>{{__('hotel.booking_history.statusPayment')}}</span>
                                        </div>
                                        <div class="status-td">
                                            <span>{{__('hotel.booking_history.status')}}</span>
                                        </div>
                                        <div class="action-td">
                                            <span>{{__('hotel.booking_history.action')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-body">
                                    @foreach($bookings as $booking)
                                        <div class="table-row  flex-column flex-lg-row">
                                            <div class="type-td">
                                                <span class="mobile-name">{{__('hotel.booking_history.type')}}</span>
                                                <div>
                                                    <i>
                                                        <img src="/images/Icon-hotel.png" alt="">
                                                    </i>
                                                    <span>{{$booking->type}}</span>
                                                </div>
                                            </div>
                                            <div class="name-td">
                                                <span class="mobile-name">{{__('hotel.booking_history.name')}}</span>
                                                <span>{{$booking->object_title}}</span>
                                            </div>
                                            <div class="date-td">
                                                <span class="mobile-name">{{__('hotel.booking_history.date')}}</span>
                                                <span>{{$booking->data_booking}}</span>
                                            </div>
                                            <div class="time-td">
                                                <span class="mobile-name">{{__('hotel.booking_history.time')}}</span>
                                                <div class="d-flex flex-column">
                                                    <div>
                                                        <span class="time-name">{{__('hotel.booking_history.check_in')}}</span>
                                                        <span class="time">{{$booking->check_in}}</span>
                                                    </div>
                                                    <div>
                                                        <span class="time-name">{{__('hotel.booking_history.check_out')}}</span>
                                                        <span class="time">{{$booking->check_out}}</span>
                                                    </div>
                                                    <div>
                                                        <span class="time-name">{{__('hotel.booking_history.duration')}}</span>
                                                        <span class="time">{{$booking->getDuration()}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="price-td">
                                                <span class="mobile-name">{{__('hotel.booking_history.price')}}</span>
                                                <span>{{number_format($booking->price, 0, '.', ' ')}} {{__('rooms.currency')}}</span>
                                            </div>
                                            <div class="status-td">
                                                <span class="mobile-name">{{__('hotel.booking_history.statusPayment')}}</span>
                                                <span>{{$booking->getPaymentStatus()}}</span>
                                            </div>
                                            <div class="status-td">
                                                <span class="mobile-name">{{__('hotel.booking_history.status')}}</span>
                                                @if($booking->status==0)
                                                    <span>{{__('hotel.booking_history.process')}}</span>
                                                @elseif($booking->status==1)
                                                    <span>{{__('hotel.booking_history.finished')}}</span>
                                                @else
                                                    <span>{{__('hotel.booking_history.cancelStatus')}}</span>
                                                @endif
                                                @if($booking->penalty_amount)
                                                    <span>{{__('booking.penalty')}} {{$booking->penalty_amount}}{{__('rooms.currency')}}</span>
                                                @endif
                                            </div>
                                            <div class="action-td">
                                                <span class="mobile-name">{{__('hotel.booking_history.action')}}</span>
                                                <div>
                                                    <button class="btn btn-blue moreBtn">{{__('hotel.booking_history.check')}}</button>
                                                    @if($booking->allowedPayment())
                                                        <a href="{{$booking->getPaymentLink()}}" class="btn btn-blue">{{__('hotel.booking_history.pay')}}</a>
                                                    @endif
                                                    <br>
                                                    @if($booking->status == 0)
                                                        <button class="btn btn-grey cancelBtn">{{__('vendor.booking_and_reports.cancel')}}</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="information-table more" style="display: none">
                                            <ul class="nav nav-tabs" id="myTab{{$booking->id}}" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="personal-info{{$booking->id}}" data-bs-toggle="tab" data-bs-target="#home{{$booking->id}}" type="button" role="tab" aria-controls="home" aria-selected="true">{{__('vendor.booking_and_reports.info')}}</button>

                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="contact-info{{$booking->id}}" data-bs-toggle="tab" data-bs-target="#profile{{$booking->id}}" type="button" role="tab" aria-controls="profile" aria-selected="false">{{__('vendor.booking_and_reports.info_booking')}}</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent{{$booking->id}}">

                                                <div class="tab-pane fade show active" id="home{{$booking->id}}" role="tabpanel" aria-labelledby="personal-info{{$booking->id}}">
                                                    <div class="personal-info-block info-block">
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.firstname')}}</h3>
                                                            <span>{{$booking->name}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.lastname')}}</h3>
                                                            <span>{{$booking->lastName}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.email')}}</h3>
                                                            <span>{{$booking->email}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.phone')}}</h3>
                                                            <span>{{$booking->phone}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.country')}}</h3>
                                                            <span>{{$booking->getCountry()}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.city')}}</h3>
                                                            <span>{{$booking->getCity()}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.address')}}</h3>
                                                            <span>{{$booking->address}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.postcode')}}</h3>
                                                            <span>{{$booking->postcode}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.special_wishes')}}</h3>
                                                            <span>{{$booking->special_wishes}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="close-block info-btn-block">
                                                        <button class="btn btn-grey close">{{__('vendor.booking_and_reports.close')}}</button>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="profile{{$booking->id}}" role="tabpanel" aria-labelledby="contact-info{{$booking->id}}">
                                                    <div class="contact-info-block info-block">
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.status')}}</h3>
                                                            {!! $booking->getStatus()!!}
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.data_booking')}}</h3>
                                                            <span>{{$booking->data_booking}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.check_in')}}</h3>
                                                            <span>{{$booking->check_in}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.check_out')}}</h3>
                                                            <span>{{$booking->check_out}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.duration')}}</h3>
                                                            <span>{{$booking->duration}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.adults')}}</h3>
                                                            <span>{{$booking->adults}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.children')}}</h3>
                                                            <span>{{$booking->children}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.room_name')}}</h3>
                                                            <span>{{$booking->room_name}}</span>
                                                        </div>
                                                        <div>
                                                            <h3>{{__('vendor.booking_and_reports.payment')}}</h3>
                                                            <span>{{$booking->payment}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="price-block">
                                                        <h3>{{__('vendor.booking_and_reports.price')}}</h3>
                                                        <span>{{number_format($booking->price, 0, '.', ' ')}} {{__('rooms.currency')}}</span>
                                                    </div>
                                                    <div class="close-block info-btn-block">
                                                        <button class="btn btn-grey close">{{__('vendor.booking_and_reports.close')}}</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="information-table contact-information-table cancel" style='display: none' id="cancelBlock_{{$booking->id}}">
                                            <div class="title-part">
                                                <h2>{{__('vendor.booking_and_reports.cancel_booking')}}</h2>
                                            </div>
                                            <div class="contact-input-part">
                                                <div>
                                                    <label id="penalty_{{$booking->id}}" for="cancel-pay{{$booking->id}}"></label>
                                                </div>
                                                <p class="error-cancel text-danger" style="display: none">Please select</p>
                                            </div>
                                            <div class="info-btn-block">
                                                <button class="btn btn-grey no">{{__('vendor.booking_and_reports.no')}}</button>
                                                <button class="btn btn-blue yes">{{__('vendor.booking_and_reports.yes')}}</button>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form action="{{ route('cancel-booking', ['locale' => App::getLocale()]) }}" style="display: none" method="post"
          class="form-cancel mx-auto col-lg-11 col-12">
        @csrf
        <input type="hidden" name="id" class="id">
        <input type="hidden" name="canceled_message" class="cancel">

    </form>
@endsection
@section('scripts')
    <script>
        $("button.moreBtn").click(function(){
            if(!$(this).parents('.table-row').next().hasClass('activeBlock')){
                $(this).parents('.table-row').next().addClass('activeBlock');
            }
            if($(this).parents('.table-row').next().next().hasClass('activeBlock')){
                $(this).parents('.table-row').next().next().removeClass('activeBlock');
            }
            $('.table-row').next().removeClass('activeBlock').slideUp();
            $(this).parents('.table-row').next().addClass('activeBlock').slideDown();
        });
        $("button.close").click(function(){
            $('.more').hide();
            $('.more').removeClass('activeBlock');
        });
        $("button.cancelBtn").click(function(){
            const blockId = $(this).parents('.table-row').next().next().attr('id');
            const orderId = blockId.split("_")[1];
            if(!$(this).parents('.table-row').next().next().hasClass('activeBlock')){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('check-penalty')}}",
                    type: "POST",
                    data: {
                        orderId: orderId
                    },
                    success: function(response) {
                        $('#penalty_' + orderId).text(response.message)
                    }
                });
                $(this).parents('.table-row').next().next().addClass('activeBlock');
            }
            if($(this).parents('.table-row').next().hasClass('activeBlock')){
                $(this).parents('.table-row').next().removeClass('activeBlock');
            }
            $('.table-row').next().next().removeClass('activeBlock').slideUp();
            $(this).parents('.table-row').next().next().addClass('activeBlock').slideDown();
        });

        $("button.no").click(function(){
            $(this).parents('.cancel').hide();
            $(this).parents('.cancel').removeClass('activeBlock');
        });
        $("button.yes").click(function(){
            var id=$(this).parents('.cancel').attr('id');
            // var radios = document.getElementsByName('cancel');
            // let selected_cancel ="";
            // for (var i = 0, length = radios.length; i < length; i++) {
            //     if (radios[i].checked) {
            //         // do whatever you want with the checked radio
            //         selected_cancel =radios[i].value;
            //
            //     }
            // }
            // if(selected_cancel == ''){
            //     $(".error-cancel").show();
            // } else {
                $(".error-cancel").hide();
                // $(".form-cancel .cancel").val(selected_cancel);
                $(".form-cancel .id").val(id.split('_')[1]);
                $(".form-cancel").submit();
                $(this).parents('.cancel').hide();
                $(this).parents('.cancel').removeClass('activeBlock');
            // }

        });
        $("#object_type").on('change', function() {
            let x ='booking-history?type='+$(this).val();
            window.location.href = x;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('object-filter')}}",
                type: "POST",
                data: {
                    type: $(this).val()
                },
                success: function(response) {
                    console.log(response)
                    $('.table-body').html(response)
                }
            });
        })
    </script>
@endsection
