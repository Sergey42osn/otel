{{--@if($errors->any())--}}
{{--<div class="alert alert-danger">--}}
{{--    <p><strong>Opps Something went wrong</strong></p>--}}
{{--    <ul>--}}
{{--        @foreach ($errors->all() as $error)--}}
{{--        <li>{{ $error }}</li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}
{{--</div>--}}
{{--@endif--}}

<!-- Modal -->
<div class="modal fade modal-style" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title lato-bold" id="exampleModalLabel">{{ __('auth.registrtaion.title') }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{ route('register')}}" class="register-form" method="POST">
                    @csrf
                    <div class="d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex flex-column mb-20">
                            <label class="lato-medium" for="name">{{ __('auth.registrtaion.name') }}</label>
                            <input type="text" placeholder="{{ __('auth.registrtaion.name') }}" id="name" class="form-control" name="name" required />
                        </div>
                        <div class="d-flex flex-column mb-20">
                            <label class="lato-medium" for="last name">{{ __('auth.registrtaion.surname') }}</label>
                            <input type="text" placeholder="{{ __('auth.registrtaion.surname') }}" class="form-control" id="last_name" name="last_name" />
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-20">
                        <label class="lato-medium" for="email">{{ __('auth.email') }}</label>
                        <input type="email" placeholder="{{ __('auth.email') }}" class="form-control" id="email" name="email" />
                    </div>
                    <div class="d-flex flex-column mb-20">
                        <label class="lato-medium" for="password">{{ __('auth.password') }}</label>
                        <input type="password" placeholder="{{ __('auth.password') }}" class="form-control" id="password" name="password" />
                    </div>
                    <div class="d-flex flex-column mb-20">
                        <label class="lato-medium" for="confirm password">{{ __('auth.registrtaion.confirm_password') }}</label>
                        <input type="password" class="form-control" placeholder="{{ __('auth.registrtaion.confirm_password') }}" id="confirm_password" name="password_confirmation" />
                    </div>
                    <div class="mb-30">
                        <button type="submit" class="btn-blue lato-semibold d-flex w-100 justify-content-center align-items-center">
                            {{ __('auth.registrtaion.register') }}
                        </button>
                    </div>
                    <div class="mb-30">
                        <label class="lato-regular checkbox-label d-flex align-items-cener" style="gap:10px">
                            <input type="checkbox" class="d-block" name="agree" id="checkbox" value="0">
                            {!! __('auth.registrtaion.terms') !!}
                        </label>
                    </div>
                    <p class="text-center">
                        {{ __('auth.registrtaion.have_account') }}
                        <a href="{{route('login')}}"> {{ __('auth.registrtaion.signin') }}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script>
    $(document).ready(function() {
        //$('#exampleModal').modal('toggle');
        $('#checkbox').change(function() {
            if ($(this).is(":checked")) {
                $(this).attr("value", 1);
            } else {
                $(this).attr("value", 0);
            }
        });
        // Register validation
        $(".register-form").validate({

            errorClass: 'is-invalid invalid-feedback',
            validClass: 'success is-valid',
            errorElement: 'span',

            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15,
                    regex: /^[a-zA-ZԱ-Ֆա-ֆа-яА-Я ]{2,20}$/,
                },
                last_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15,
                    regex: /^[a-zA-ZԱ-Ֆա-ֆа-яА-Я ]{2,20}$/,
                },

                email: {
                    email: true,
                    required: true,
                    regex: /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
                },
                password: {
                    required: true,
                    minlength: 8,
                    // pwcheck: true,
                    regex: /^(?=.*[\d])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,15}$/,
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    // pwcheck: true,
                    regex: /^(?=.*[\d])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,15}$/,
                    equalTo: "#password"
                },
                agree: {
                    required: true,
                }
            },



            messages: {
                name: {
                    required: "Please enter your first name.",
                    regex: "Please enter only letters.",
                },
                last_name: {
                    required: "Please enter your last name.",
                    regex: "Please enter only letters.",
                },
                email: {
                    required: "Please enter your email address.",
                    regex: "Please enter a valid email address.",
                },
                password: {
                    required: 'passwords.required',
                    minlength: "password.password.minLenght",
                    pwcheck: "Password must contain letters and digits.",
                },
                password_confirmation: {
                    required: "Please provide a password.",
                    minlength: "The password must be at least 8 characters.",
                    equalTo: "Password and confirmation password do not match.",
                    pwcheck: "Password must contain letters and digits.",
                },

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
                form.submit();
            }
        });




        $(document).ready(function() {
            jQuery.extend(jQuery.validator.messages, {
                required: "{{ __('validation.jq_validate_msgs.required') }}",
                remote: "{{ __('validation.jq_validate_msgs.remote') }}",
                email: "{{ __('validation.jq_validate_msgs.email') }}",
                url: "{{ __('validation.jq_validate_msgs.url') }}",
                date: "{{ __('validation.jq_validate_msgs.date') }}",
                dateISO: "{{ __('validation.jq_validate_msgs.dateISO') }}",
                number: "{{ __('validation.jq_validate_msgs.number') }}",
                digits: "{{ __('validation.jq_validate_msgs.digits') }}",
                creditcard: "{{ __('validation.jq_validate_msgs.creditcard') }}",
                equalTo: "{{ __('validation.jq_validate_msgs.equalTo') }}",
                accept: "{{ __('validation.jq_validate_msgs.accept') }}",
                maxlength: jQuery.validator.format("{{ __('validation.jq_validate_msgs.maxlength') }}"),
                minlength: jQuery.validator.format("{{ __('validation.jq_validate_msgs.minlength') }}"),
                rangelength: jQuery.validator.format("{{ __('validation.jq_validate_msgs.rangelength') }}"),
                range: jQuery.validator.format("{{ __('validation.jq_validate_msgs.range') }}"),
                max: jQuery.validator.format("{{ __('validation.jq_validate_msgs.max') }}"),
                min: jQuery.validator.format("{{ __('validation.jq_validate_msgs.min') }}"),
                regex: "{{ __('validation.jq_validate_msgs.regex') }}",
                pwcheck: "{{ __('validation.jq_validate_msgs.pwcheck') }}",
            });
        });

    })
</script>
