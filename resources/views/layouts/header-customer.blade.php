<header>
    <div class="bg-blue">
        <div class="container">
            <div class="header-part header-top-part">
                <div class="social-part d-flex">
                    <a href="" class="social-items wc-icon"></a>
                    <a href="" class="social-items ok-icon"></a>
                    <a href="" class="social-items yandex-icon"></a>
                    <a href="" class="social-items twitter-icon"></a>
                    <a href="" class="social-items telegram-icon"></a>
                    <a href="mailto:contact@ruking.test" class="email">contact@ruking.test</a>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="lang-icon">
                        <img src="{{ asset('images/download.png')}}" alt="">
                    </div>
                    @auth
                        <div class="registration-part dropdown">
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
                            <button class="nameSurname dropdown-toggle" data-bs-toggle="dropdown">{{ Auth::user()->name}}</button>
                            <div class="dropdown-menu">
                                <ul class="personal-menu">
                                    <li>
                                        <form action="{{route('customer-logout', ['locale' => App::getLocale()])}}" method="post">
                                            @csrf
                                            <button type="submit" class="dropdown-item w-100">Logout</button>
                                        </form>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Link 2</a></li>
                                    <li><a class="dropdown-item" href="#">Link 3</a></li>
                                </ul>
                            </div>
                        </div>

                    @else
                        <nav class="menu header-menu header-menu-desktop">
                            <ul>
                                <li><div class="login-btn" data-bs-toggle="modal" data-bs-target="#loginModal">{{__('auth.login')}}</div></li>
                                <li><div class="register-btn" data-bs-toggle="modal" data-bs-target="#registerModal">{{__('auth.register')}}</div></li>
                            </ul>
                        </nav>
                    @endauth


                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="header-part header-bottom-part">
                <div class="logo-part">
                    <img src="images/logo.svg" alt="">
                </div>
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
                                <li><a class="dropdown-item" href="#">Link 1</a></li>
                                <li><a class="dropdown-item" href="#">Link 2</a></li>
                                <li><a class="dropdown-item" href="#">Link 3</a></li>
                            </ul>
                        </div>

                    </div>
                    <nav class="menu header-menu header-menu-desktop">
                        <ul>
                            <li><a href="{{ route('hotels')}}" class="menu-item {{ (request()->is('hotels*')) ? 'active' : '' }}">{{ __('navs.hotels')}}</a></li>
                            <li><a href="{{ route('appartments')}}" class="menu-item {{ (request()->is('appartments*')) ? 'active' : '' }}">{{ __('navs.appartments')}}</a></li>
                            <li><a href="{{ route('villas')}}" class="menu-item {{ (request()->is('villas*')) ? 'active' : '' }}">{{ __('navs.villas')}}</a></li>
                            <li><a href="{{ route('youth-hotels')}}" class="menu-item {{ (request()->is('youth-hotels*')) ? 'active' : '' }}">{{ __('navs.youth_hotels')}}</a></li>
                            <li><a href="{{ route('blog')}}" class="menu-item {{ (request()->is('blogs*')) ? 'active' : '' }}">{{ __('navs.blogs')}}</a></li>
                        </ul>
                    </nav>
                    <nav class="menu header-menu header-menu-mobile dropdown">
                        <button class="mobile-nav-btn dropdown-toggle" data-bs-toggle="dropdown"></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('hotels')}}" class="menu-item dropdown-item {{ (request()->is('hotels*')) ? 'active' : '' }}">{{ __('navs.hotels')}}</a></li>
                            <li><a href="{{ route('appartments')}}" class="menu-item dropdown-item {{ (request()->is('appartments*')) ? 'active' : '' }}">{{ __('navs.appartments')}}</a></li>
                            <li><a href="{{ route('villas')}}" class="menu-item dropdown-item {{ (request()->is('villas*')) ? 'active' : '' }}">{{ __('navs.villas')}}</a></li>
                            <li><a href="{ route('youth-hotels')}}" class="menu-item dropdown-item {{ (request()->is('youth-hotels*')) ? 'active' : '' }}">{{ __('navs.youth_hotels')}}</a></li>
                            <li><a href="{{ route('blog')}}" class="menu-item dropdown-item {{ (request()->is('blogs*')) ? 'active' : '' }}">{{ __('navs.blogs')}}</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
