<script src="{{ asset('/js/cookie.js')}}"></script>
<script src="{{ asset('/js/script.js')}}"></script>

<footer>
    <div class="container">
        <div class="footer-block">
            <div class="footer-logo-box">
                <div class="logo-rectangle">
                    <figure>
                        <img src="{{ asset('images/logo-min.svg')  }}" alt="" class="footer-logo">
                    </figure>
                </div>
            </div>
            <div class="footer-part">
                <div class="footer-block-column">
                    <h2 class="footer-title">{{__("home.footer.contacts")}}</h2>
                    <div class="phone-box">
                        <span>{{__("home.footer.tel")}}</span>
                        <a href="tel:88001011180">8 800 101 11 80</a><br>
                        <a href="tel:+74994998885">+7 499 499 88 85</a>
                    </div>
                    <div class="mail-box">
                        <span>{{__("home.footer.email")}}</span>
                        <a href="mailto:contact@ruking.test">info@ruking.ru</a>
                    </div>

                    <div class="social-box">
                        <span>{{__("home.footer.social")}}</span>
                        <a href="https://vk.com/rukingru" target="_blank">
                            <img src="{{ asset('images/awesome-vk-footer.svg')  }}" alt="">
                        </a>
                        <a href="https://ok.ru/group/70000000016981" target="_blank">
                            <img src="{{ asset('images/awesome-odnoklassniki-footer.svg')  }}" alt="">
                        </a>
                        <a href="https://zen.yandex.ru/rukingru" target="_blank">
                            <img src="{{ asset('images/yandex-footer.svg') }}" alt="">
                        </a>
                        <a href="https://twitter.com/Ruking20503428" target="_blank">
                            <img src="{{ asset('images/awesome-twitter-footer.svg') }}" alt="">
                        </a>
                        <a href="https://t.me/rukingru" target="_blank">
                            <img src="{{ asset('images/awesome-telegram-footer.svg') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="footer-block-column">
                    <h2 class="footer-title">{{__("home.footer.variants")}}</h2>
                    <ul class="footer-menu">
                        <li>
                            <a href="{{ route('search', [App::getLocale(), 'accommodations' => ['hotel']])}}">
                                {{__('navs.hotels')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('search', [App::getLocale(), 'accommodations' => ['apartment']])}}">
                                {{__('navs.appartments')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('search', [App::getLocale(), 'accommodations' => ['villa']])}}">
                                {{__('navs.villas')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('search', [App::getLocale(), 'accommodations' => ['youth-hotel']])}}">
                                {{__('navs.youth_hotels')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('blog',App::getLocale())}}" class="menu-item">
                                {{__('navs.blogs')}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="footer-block-column">
                    <h2 class="footer-title">{{__("home.footer.useful_links")}}</h2>
                    <ul>
                        <li>
                            <a href="{{ route('faq_page',App::getLocale()) }}">{{__('navs.faq')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('legal-page',App::getLocale()) }}">{{__('navs.legal')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('privacy_page',App::getLocale()) }}">{{__('navs.privacy')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-part">
        <span>Copyright © 2022 by Ruking</span>
    </div>
    <div class="cookie-agreement " style="border-top: 1px solid rgba(0,0,0,0.1);position: fixed; bottom: 0; background-color: #fff; padding: 60px;z-index: 10;display: none">
        <div class="row align-items-center">
            <div class="col-sm-8">
                <p>{{__('home.cookieText')}}</p>
            </div>
            <div class="col-sm-4 ">
                <button class="btnCookieAgreement-go btn btn-primary" type="button" style="padding: 5px 50px"> {{__('home.cookieSubmit')}} </button>
            </div>
        </div>
    </div>
</footer>
