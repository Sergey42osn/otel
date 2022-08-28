<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title lato-bold" id="registerModalLabel">{{__('auth.register')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="handleRegisterAjax" action="{{route('customer.registration')}}" method="post">
                    @csrf
                    <div class="d-flex flex-column flex-md-row justify-content-between name-surname-block">
                        <div class="d-flex flex-column mb-20">
                            <label class="lato-medium" for="name">{{__('auth.registrtaion.name')}}</label>
                            <input type="text" placeholder="{{__('auth.registrtaion.name')}}" id="name" name="name" class="inputId"/>
                        </div>
                        <div class="d-flex flex-column mb-20">
                            <label class="lato-medium" for="last-name">{{__('auth.registrtaion.surname')}}</label>
                            <input type="text" placeholder="{{__('auth.registrtaion.surname')}}" id="last_name" name="last_name" class="inputId"/>
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-20">
                        <label class="lato-medium" for="email">{{__('auth.email')}}</label>
                        <input type="text" placeholder="{{__('auth.email')}}" id="email" name="email" class="inputId"/>
                    </div>
                    <div class="d-flex flex-column mb-20">
                        <label class="lato-medium" for="password">{{__('auth.password')}}</label>
                        <input type="password" placeholder="{{__('auth.password')}}" id="password" name="password" class="inputId"/>
                    </div>
                    <div class="d-flex flex-column mb-20">
                        <label for="confirm-password">{{__('auth.registrtaion.confirm_password')}}</label>
                        <input type="password" placeholder="{{__('auth.registrtaion.confirm_password')}}" id="password_confirmation" name="password_confirmation" class="inputId"/>
                    </div>
                    <div class="mb-20">
                        <button type="submit" disabled class="btn btn-blue reg-btn lato-semibold d-flex w-100 justify-content-center align-items-center">
                            {{__('auth.register')}}
                        </button>
                    </div>
                    <div class="social-icons-block">
                        <span class="">{{__('auth.or')}}</span>
                        <div class="social-icons-inner-block">
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
                    <div class="modal-check-pp-block">
                        <input type="checkbox" id="agree" name="agree"  class="inputId"/>
                        <label class="checkBtn-label text-black" for="agree">{!! __('auth.registrtaion.terms') !!}
                        </label>
                    </div>
                    <p class="text-center lato-semibold mb-0">
                        {{__('auth.registrtaion.have_account')}}
                        <a href="#" class="open-login-modal">{{__('auth.registrtaion.signin')}}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
