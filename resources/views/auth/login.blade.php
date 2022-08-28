<!-- Signin Modal -->
<div class="modal fade modal-style" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title lato-bold" id="signinModalLabel">{{ __('auth.title')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('login')}}" method="POST" class="login-form">
                    @csrf
                    <div class="d-flex flex-column mb-20">
                        <label class="lato-medium" for="email">{{ __('auth.email')}}</label>
                        <input type="email" placeholder="{{ __('auth.email')}}" id="email" class="form-control" name="email" />
                    </div>
                    <div class="d-flex flex-column mb-20">
                        <label class="lato-medium" for="password">{{ __('auth.password')}}</label>
                        <input type="password" placeholder="{{ __('auth.password')}}" id="password" class="form-control" name="password" />
                    </div>

                    <div class="mb-30">
                        <button type="submit" class="btn-blue lato-semibold d-flex w-100 justify-content-center align-items-center">
                            {{ __('auth.sign_in')}}
                        </button>
                    </div>
                    <div class="privacy-text text-center">
                        {!! __('auth.terms')!!}
                    </div>
                    <p class="text-center lato-semibold mb-0">
                        {{ __('auth.have_register')}}
                        <a href="{{ route('register')}}">{{ __('auth.register')}}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/js/jquery.validate.min.js')}}"></script>
<script>
    $(document).ready(() => {
        //$('#signinModal').modal("toggle")
        // Login validation
        $(".login-form").validate({
            errorClass: 'is-invalid invalid-feedback',
            validClass: 'success is-valid',
            errorElement: 'span',

            rules: {
                email: {
                    required: true,
                    email: true,
                    regex: /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
                },
                password: {
                    required: true,
                    minlength: 8
                },
            },

            messages: {
                email: {
                    required: "Please enter your email address",
                    regex: "Please enter a valid email address",
                },
                password: {
                    required: "Please provide a password",
                    minlength: "The password must be at least 8 characters."
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

        $.validator.addMethod("regex", function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        });

        $.validator.addMethod("pwcheck", function(value) {
            return /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(value) && /\d/.test(value);
        });
    })
</script>
