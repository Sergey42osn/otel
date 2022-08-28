<section class="subscribe-section">
    <div class="subscribe-text-block">
        <h2>{{__('accommodation.subscribe_title')}}</h2>
        <h3>{{__('accommodation.sign_up_and_we_send_the_best_deals_to_you')}}</h3>

        <div class="subscribe-form">
            <form method="POST" class="subscribe-form" id="subscribe-form">
                @csrf
                <input type="text" placeholder="{{__('accommodation.e_mail')}}" name="subscribe_email">
                <button id="subscribe-btn" type="button" class="red-btn">{{__('accommodation.subscribe_btn')}}</button>
            </form>
        </div>
        <div class="mx-auto col-md-6 alert alert-success success-subscribe" role="alert" style="display:none;">
            {{__('home.subscribe_success')}}
        </div>
    </div>
    <figure class="subscribe-block" style="height:350px;">
        <img src="{{asset('images/pietro-de-grandi-T7K4aEPoGGk-unsplash.png')}}" alt="">
    </figure>
</section>
<script>
    $('#subscribe-btn').click(function() {
        let emial_input = $('input[name="subscribe_email"]');
        let lang = $('html')[0].lang;
        if(emial_input.val() == '' || !emial_input.val().toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
            emial_input.addClass('border-danger');
            $('.success-subscribe').hide();
        } else {
            emial_input.removeClass('border-danger');
            var token = $('input[name="_token"]').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : lang+"/send-mail",
                data : {'token' : token, 'email': emial_input.val()},
                type : 'POST',
                dataType : 'json',
                success : function(result){
                    $('.success-subscribe').show();
                    $('#subscribe-form')[0].reset();
                    setTimeout(function() {
                        $('.success-subscribe').hide();
                    }, 5000);
                }
            });
        }
    });

    $('#subscribe-form').find("input").keypress(function (e) {
        if (e.which == 13) {

            let emial_input = $('input[name="subscribe_email"]');
            if(emial_input.val() == '' || !emial_input.val().toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
                emial_input.addClass('border-danger');
            } else {
                emial_input.removeClass('border-danger');
                var token = $('.subscribe-form').find('input[name="_token"]').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "/send-mail",
                    data : {'token' : token},
                    type : 'POST',
                    dataType : 'json',
                    success : function(result){
                        console.log(result);
                        $('.success-subscribe').attr("style", 'display:block');
                    }
                });
            }
            return false;
        }
    });
</script>
