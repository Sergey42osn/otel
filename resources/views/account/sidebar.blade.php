<aside class="narrow">
    <div class="vender-aside-menu">
        <ul>
            <li class="vender-menu-item person-menu-item">
                <a href="{{route('account', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="person-icon"></i>
                    </span>
                    <span class="vender-menu-item-text">{{__('account.personal information')}}</span>
                </a>
            </li>
            <li class="vender-menu-item security-menu-item">
                <a href="{{route('security', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="security-icon"></i>
                    </span>
                    <span class="vender-menu-item-text">{{__('account.security')}}</span>
                </a>
            </li>
            <li class="vender-menu-item favourite-menu-item">
                <a href="{{route('favourites', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="favourite-icon"></i>
                    </span>
                    <span class="vender-menu-item-text">{{__('account.favourites')}}</span>
                </a>
            </li>
            <li class="vender-menu-item history-menu-item">
                <a href="{{route('booking-history', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="booking-icon"></i>
                    </span>
                    <span class="vender-menu-item-text">{{__('account.booking-history')}}</span>
                </a>
            </li>
            <li class="vender-menu-item">
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                     <span class="vender-menu-icon">
                            <i class="log-out-icon"></i>
                        </span>
                    <span  class="vender-menu-item-text">{{__('account.log out')}}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
