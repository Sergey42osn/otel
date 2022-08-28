<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="modal_login2">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title lato-bold" id="signinModalLabel">{{__('auth.log_in')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="customerLoginForm" action="{{url('userlogin')}}">
                    @csrf
                    <div class="d-flex flex-column mb-20">
                        <label class="lato-medium" for="email">{{__('auth.email')}}</label>
                        <input type="text" name="email" placeholder="{{__('auth.email')}}" id="email"/>
                    </div>

                    <div class="d-flex flex-column mb-30">
                        <label class="lato-medium" for="password">{{__('auth.password')}}</label>
                        <input type="password" name="password" placeholder="{{__('auth.password')}}" id="password"/>
                    </div>
                    @if(Session::has('userExist'))
                        <p class="text-danger session-error">
                            <strong>{!! session('userExist')!!}</strong>
                        </p>
                    @endif

                    @if(Session::has('notActive'))
                        <p class="text-danger notActive-error">

                        </p>
                    @endif

                    <div class="mb-2">
                        <button type="submit" class="btn-blue lato-semibold d-flex w-100 justify-content-center align-items-center">
                            {{__('auth.log_in')}}
                        </button>
                    </div>
                    <div class="d-flex flex-column mb-20 text-end">
                        <a href="{{route('forgot-password-page', ['locale' => App::getLocale()])}}"> {{__('auth.forgotPassword.forgotPassword')}}? </a>
                    </div>
                    <div class="social-icons-block">
                        <span class="">{{__('auth.or')}}</span>
                        <div class="social-icons-inner-block justify-content-evenly">
                            <div class="social-icon-box">
                                <a href="{{url('/customer/auth/vk')}}">
                                    <figure>
                                        <img src="{{ asset('/images/Icon-logo-vk.png')}}" alt="vk-icon">
                                    </figure>
                                </a>
                            </div>
                            <div class="social-icon-box">
                                <a href="{{url('/customer/auth/ok')}}">
                                    <figure>
                                        <img src="{{ asset('/images/Icon-odnoklassniki.png')}}" alt="odnoklassniki-icon">
                                    </figure>
                                </a>
                            </div>
                            <div class="social-icon-box">
                                <a href="{{url('/customer/auth/google')}}">
                                    <figure>
                                        <img src="{{ asset('/images/icon-google.png')}}" alt="google-icon">
                                    </figure>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="privacy-text text-center">
                        {{__('auth.logIn.terms')}}
                        <a href="{{route('legal-page', ['locale' => App::getLocale()])}}" target="_blank">{{__("page.legal.legal_information")}}</a>
                        {{__('auth.logIn.and')}}
                        <a href="{{route('privacy_page', ['locale' => App::getLocale()])}}" target="_blank">{{__('auth.logIn.privacy')}}</a>
                    </div>
                    <p class="text-center lato-semibold mb-0">
                        {{__('auth.not account')}}
                        <a href="#" class="open-register-modal">{{__('auth.logIn.login')}}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $( document ).ready(function() {
        if($(".session-error").length!=0) {
            $("#loginModal").modal("show");
        }
        if($(".notActive-error").length!=0) {
            $("#confirmPhoneModal").modal("show");
        }
    })
</script>




