<div class="modal fade" id="confirmPhoneModal" tabindex="-1" aria-labelledby="confirmPhoneModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title lato-bold" id="confirmPhoneModalLabel">{{__('auth.Confirm account')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class=" confirm-body">
                    <span>{{__('auth.Confirm phone text')}}</span>
                    <a class="phone_confirm"></a>
{{--                    <p>{{__('auth.Confirm phone text2')}}<p>--}}
                </div>

                <div class=" confirm-body1">
                    <form method="post" action="{{route('customer.activate_phone')}}">
                        @csrf
                        <div class="form-group" id="form_group">
                            <label for="sms_code">{{__('auth.sms_code')}}</label>
                            <input type="text" class="form-control inputId" id="sms_code" name="sms_code">
                            <div class="text-danger" style="display:none" id="wrong_code">wrong code</div>
                            <button type="button" id="check_buttons" class="btn  btn-primary mt-2" >{{__('auth.Send')}}</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

    $("#check_buttons").click(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('customer.activate_phone')}}",
            type: "POST",
            data: {
                code: $("#confirmPhoneModal #sms_code").val(),
                phone: $("#confirmPhoneModal #phone_with_code").val()
            },

            success: function(response) {
                console.log("5454");
                console.log(response);
                if(response.status){
                    $("#wrong_code").css("display","none");
                    $("#check_buttons").attr("type","submit");
                    // console.log("ok");
                    location.reload();
                } else {
                    $("#wrong_code").html(response.message);
                    $("#check_buttons").attr("type","button");
                    $("#wrong_code").css("display","block");
                    // console.log("wrong");
                }
            }
        });
    });
</script>
