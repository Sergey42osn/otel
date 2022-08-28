@guest
    @include('auth.login')
    @include('auth.register')
@endguest

<header>
    <div class="bg-blue">
        <div class="container">
            <div class="header-part header-top-part">
                <div class="social-part d-flex">
                    <a href="https://vk.com/rukingru" class="social-items wc-icon" target="_blank"></a>
                    <a href="https://ok.ru/group/70000000016981" class="social-items ok-icon" target="_blank"></a>
                    <a href="https://zen.yandex.ru/rukingru" class="social-items yandex-icon" target="_blank"></a>
                    <a href="https://twitter.com/Ruking20503428" class="social-items twitter-icon" target="_blank"></a>
                    <a href="https://t.me/rukingru" class="social-items telegram-icon" target="_blank"></a>
                    <a href="mailto:info@ruking.ru" class="email">info@ruking.ru</a>
                </div>
                <div class="d-flex align-items-center justify-content-center position-relative">
                    <div class="lang-icon">
                        @php
                            $segments = \Request::segments();
                            $base_path = env('APP_URL');
                        @endphp
                        <a href="flag-img">
                            @if(App::getLocale() == 'en')

                                <a href="{{str_replace($base_path.'/en', $base_path.'/ru', url()->full())}}">
                                    <img src="{{ asset('images/rus-flag.png')}}" alt="ru">
                                </a>
                            @else
                                @php

                                    $replace = $base_path.'/ru';
                                    if(empty($segments)) {
                                        $replace = $base_path;
                                    }
                                @endphp
                            @if(strpos(url()->full(),'am/ru'))
                                    <a href="{{str_replace('am/ru','am/en', url()->full())}}">
                                        <img src="{{ asset('images/download.png')}}" alt="en">
                                    </a>
                                @else
                                    <a href="{{url()->full().'/en'}}">
                                        <img src="{{ asset('images/download.png')}}" alt="en">
                                    </a>
                                @endif

                            @endif
                        </a>
                    </div>

                    @auth
                        @if(Auth::user()->role_id === 1)
                            <a href="{{route('register_object', ['locale' => App::getLocale()])}}" class="d-none d-md-block">{{ __('auth.register_object_button') }}</a>
                        @endif
                        <div class="registration-part account-signOUt-dropdown dropdown">
                            <div class="personal-img">
                                @if(Auth::user()->role_id != 2)
                                    @if(!empty(Auth::user()->image->url))
                                        <img src="{{asset('storage/uploads/'.Auth::user()->image->url)}}" alt="person">
                                    @else
                                        <img src="/images/users/avatar/no-avatar.png" alt="person">
                                    @endif
                                @else
                                    <img src="{{\Auth::user()->getAvatar()}}" alt="person">
                                @endif
                            </div>
                            <button class="nameSurname dropdown-toggle" data-bs-toggle="dropdown">{{Auth::user()->name}}</button>
                            <div class="dropdown-menu">
                                <ul class="personal-menu">
                                    <li class="account-link">
                                        <a href="{{Auth::user()->role_id != 2 ? route('user.vendor.info', ['locale' => App::getLocale()]) : route('account', ['locale' => App::getLocale()])}}">
                                            <i><img src="/images/account-icon.png" alt="icon"></i>
                                            {{__('account.my_account')}}
                                        </a>
                                    </li>
                                    <li class="signOut-link">
                                        <form action="{{route('logout')}}" method="post">
                                            @csrf
                                            <button type="submit" class="dropdown-item w-100">
                                                <i><img src="/images/signOut-icon.png" alt="icon"></i>
                                                {{__('auth.sign_out')}}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <a class="auth-link" data-bs-toggle="modal" data-bs-target="#vendorLoginModal">{{ __('auth.register_object_button') }}</a>
                        <a class="auth-link d-none" data-modal="#signinModal">{{ __('auth.sign_in')  }}</a>
                        <a class="auth-link d-none" data-modal="#vendorRegisterModal">{{ __('auth.register')  }}</a>
                        <a class="auth-link login-btn" data-bs-toggle="modal" data-bs-target="#loginModal">{{__('vendor.login')}}</a>
                        <a class="auth-link register-btn" data-bs-toggle="modal" data-bs-target="#registerModal">{{__('vendor.register')}}</a>
                        <!-- <nav class="menu header-menu header-menu-desktop">
                            <ul>
                                <li><a class="login-btn" data-bs-toggle="modal" data-bs-target="#loginModal">{{__('vendor.login')}}</a></li>
                                <li><a class="register-btn" data-bs-toggle="modal" data-bs-target="#registerModal">{{__('vendor.register')}}</a></li>
                            </ul>
                        </nav> -->

                    @endauth
                </div>
            </div>
        </div>
    </div>
    <div class="position-relative">
        <div class="container">
            <div class="header-part header-bottom-part">
                <div class="logo-part">
                    <a href="/{{App::getLocale()}}">
                        <img src="{{asset('images/logo.svg')}}" alt="">
                    </a>
                </div>
                @auth()
                    <div class="d-flex">
                        <div class="registration-part mobile-registration-part dropdown">
                            <div class="personal-img">
                                @if(Auth::user()->role_id != 2)
                                    @if(!empty($user->image->url))
                                        <img src="{{asset('storage/uploads/'.$user->image->url)}}" alt="person">
                                    @else
                                        <img src="/images/users/avatar/no-avatar.png" alt="person">
                                    @endif
                                @else
                                    <img src="{{\Auth::user()->getAvatar()}}" alt="person">
                                @endif

                            </div>
                            <button class="nameSurname dropdown-toggle" data-bs-toggle="dropdown"></button>
                            <div class="dropdown-menu">
                                <ul class="personal-menu">
                                        <li class="account-link">
                                            <a href="{{Auth::user()->role_id == 1 ? route('user.vendor.info', ['locale' => App::getLocale()]) : route('account', ['locale' => App::getLocale()])}}">
                                                <i><img src="/images/account-icon.png" alt="icon"></i>
                                                {{__('account.my_account')}}</li>
                                            </a>
                                        <li class="signOut-link">
                                            <form action="{{route('logout')}}" method="post">
                                                @csrf
                                                <button type="submit" class="dropdown-item w-100">
                                                    <i><img src="/images/signOut-icon.png" alt="icon"></i>
                                                    {{__('auth.sign_out')}}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                    @endauth
                    <nav class="menu header-menu header-menu-desktop">
                        <ul>
                            <li><a href="{{ route('search', ['locale' => App::getLocale() , 'accommodations' => ['hotel']])}}" class="menu-item">{{__('navs.hotels')}}</a></li>
                            <li><a href="{{ route('search', ['locale' => App::getLocale() , 'accommodations' => ['apartment']])}}" class="menu-item">{{__('navs.appartments')}}</a></li>
                            <li><a href="{{ route('search', ['locale' => App::getLocale() , 'accommodations' => ['villa']])}}" class="menu-item">{{__('navs.villas')}}</a></li>
                            <li><a href="{{ route('search', ['locale' => App::getLocale() , 'accommodations' => ['youth-hotel']])}}" class="menu-item">{{__('navs.youth_hotels')}}</a></li>
                            <li><a href="{{ route('blog',App::getLocale())}}" class="menu-item">{{__('navs.blogs')}}</a></li>
                        </ul>
                    </nav>
                    <div class="d-flex d-md-none">
                        <!-- <a href="http://ruking.production.am/ru/list" class="" data-modal="#vendorRegisterModal"> <img src="/images/Login-icon.png" alt=""></a> -->
                        @guest()
                            <button class="mobile-logIn-btn"  data-bs-target="#loginModal" data-bs-toggle="modal">
                                <img src="/images/Login-icon.png" alt="">
                            </button>
                        @endguest
                        <nav class="menu header-menu header-menu-mobile dropdown">
                            <button class="mobile-nav-btn dropdown-toggle" data-bs-toggle="dropdown"></button>
                            <div class="dropdown-menu" id="header-mobile-menu">
                                <div class="close-block">
                                    <button class="dropdown-close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                            <g id="Group_85" data-name="Group 85" transform="translate(-981 -281)">
                                            <rect id="Rectangle_151" data-name="Rectangle 151" width="29.167" height="1.945" transform="translate(982.375 281) rotate(45)" fill="#2576EC"></rect>
                                            <rect id="Rectangle_152" data-name="Rectangle 152" width="29.168" height="1.945" transform="translate(1003 282.376) rotate(135)" fill="#2576EC"></rect>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                                <div class="more-block">
                                    <h2>Еще</h2>
                                    <ul class="mobile-list">
                                        <li>
                                            <!-- <a href=""><i class="mobile-flag">
                                                <img src="/images/rus-flag.png" alt="flag">
                                            </i>Русский</a>
                                        -->
                                        <div class="lang-icon">
                                                @php
                                                    $segments = \Request::segments();
                                                    $base_path = env('APP_URL');
                                                @endphp
                                                <a href="flag-img">
                                                    @if(App::getLocale() == 'en')
                                                        <a href="{{str_replace($base_path.'/en', $base_path.'/ru', url()->full())}}">
                                                            <img src="{{ asset('images/rus-flag-mobile.png')}}" alt="ru">
                                                            <span>Русский</span>
                                                        </a>
                                                    @else
                                                        @php
                                                            $replace = $base_path.'/ru';
                                                            if(empty($segments)) {
                                                                $replace = $base_path;
                                                            }
                                                        @endphp
                                                        <a href="{{str_replace($replace, $base_path.'/en', url()->full())}}">
                                                            <img src="{{ asset('images/Eng flag-mobile.svg')}}" alt="en">
                                                            <span>English</span>
                                                        </a>
                                                    @endif
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            @auth
                                                @if(Auth::user()->role_id == 1)
                                                    <a href="{{route('register_object', ['locale' => App::getLocale()])}}" class="d-md-block">
                                                        <i class="mobile-home">
                                                            <img src="{{ asset('images/mobile-home.png')}}">
                                                        </i>
                                                        {{ __('auth.register_object_button') }}
                                                    </a>
                                                @endif
                                            @else
                                                <a class="auth-link" data-modal="#vendorLoginModal">
                                                    <i class="mobile-home">
                                                        <img src="{{ asset('images/mobile-home.png')}}">
                                                    </i>
                                                    {{ __('auth.register_object_button') }}
                                                </a>
                                            @endauth
                                        </li>
                                    </ul>
                                </div>
                                <div class="more-block">
                                    <h2>Меню</h2>
                                    <ul class="mobile-list">
                                        <li>
                                            <a href="{{ route('search', ['locale' => App::getLocale() , 'accommodations' => ['hotel']])}}"><i class="mobile-flag" >
                                                <img src="/images/mobile-hotel.png" alt="flag">
                                            </i>{{ __('navs.hotels')}}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('search', ['locale' => App::getLocale() , 'accommodations' => ['apartment']])}}"><i class="mobile-home">
                                                <img src="/images/mobile-appartment.png" alt="image">
                                            </i>{{ __('navs.appartments')}}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('search', ['locale' => App::getLocale() , 'accommodations' => ['villa']])}}"><i class="mobile-flag">
                                                <img src="/images/mobile-villa.png" alt="flag">
                                            </i>{{ __('navs.villas')}}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('search', ['locale' => App::getLocale() , 'accommodations' => ['youth-hotel']])}}"><i class="mobile-home">
                                                <img src="/images/mobile-youth-hotel.png" alt="image">
                                            </i>{{ __('navs.youth_hotels')}}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('blog',App::getLocale())}}"><i class="mobile-youth-hotel">
                                                <img src="/images/mobile-blog.png" alt="image">
                                            </i>{{ __('navs.blogs')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- <ul >
                                    <li><a href="{{ route('search')}}/{{App::getLocale()}}?rangeOne=800&rangeTwo=8000&accommodations%5Bhotel%5D=on&place_name=&place_id=&place_type=&check_in=06%2F28%2F2022&check_out=06%2F28%2F2022&datefilter=&rooms=1&adults=1&children=0" class="menu-item dropdown-item {{ (request()->is('hotels*')) ? 'active' : '' }}">{{ __('navs.hotels')}}</a></li>
                                    <li><a href="{{ route('search')}}/{{App::getLocale()}}?rangeOne=800&rangeTwo=8000&accommodations%5Bapartment%5D=on&place_name=&place_id=&place_type=&check_in=06%2F28%2F2022&check_out=06%2F28%2F2022&datefilter=&rooms=1&adults=1&children=0" class="menu-item dropdown-item {{ (request()->is('appartments*')) ? 'active' : '' }}">{{ __('navs.appartments')}}</a></li>
                                    <li><a href="{{ route('search')}}/{{App::getLocale()}}?rangeOne=800&rangeTwo=8000&accommodations%5Bvilla%5D=on&place_name=&place_id=&place_type=&check_in=06%2F28%2F2022&check_out=06%2F28%2F2022&datefilter=&rooms=1&adults=1&children=0" class="menu-item dropdown-item {{ (request()->is('villas*')) ? 'active' : '' }}">{{ __('navs.villas')}}</a></li>
                                    <li><a href="{{route('search')}}/{{App::getLocale()}}?rangeOne=800&rangeTwo=8000&accommodations%5Byouth-hostel%5D=on&place_name=&place_id=&place_type=&check_in=06%2F28%2F2022&check_out=06%2F28%2F2022&datefilter=&rooms=1&adults=1&children=0" class="menu-item dropdown-item {{ (request()->is('youth-hotels*')) ? 'active' : '' }}">{{ __('navs.youth_hotels')}}</a></li>
                                    <li><a href="{{ route('blog',App::getLocale())}}" class="menu-item dropdown-item {{ (request()->is('blog*')) ? 'active' : '' }}">{{ __('navs.blogs')}}</a></li>
                                </ul> -->
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
