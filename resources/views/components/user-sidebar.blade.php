<aside class="narrow">
    <div class="vender-aside-menu">
        <ul>
            <li class="vender-menu-item person-menu-item">
                <a href="{{route('user.vendor.info', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="person-icon"></i>
                    </span>
                    <span class="vender-menu-item-text">{{ __('vendor.personal_information')}}</span>
                </a>
            </li>
            @if(App\Models\User::getPermission('security'))
                <li class="vender-menu-item security-menu-item">
                    <a href="{{route('user.security', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="security-icon"></i>
                    </span>
                        <span class="vender-menu-item-text">{{ __('hotel.security')}}</span>
                    </a>
                </li>
            @endif
            @if(App\Models\User::getPermission('booking_and_reports'))
                <li class="vender-menu-item history-menu-item">
                    <a href="{{route('user.booking-and-reports', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="booking-icon"></i>
                    </span>
                        <span class="vender-menu-item-text">{{ __('vendor.booking_and_reports.booking_reports')}}</span>
                    </a>
                </li>
            @endif
            @if(App\Models\User::getPermission('reviews'))
                <li class="vender-menu-item review-menu-item">
                    <a href="{{route('user.reviews', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="review-icon"></i>
                    </span>
                        <span class="vender-menu-item-text">{{ __('hotel.reviews')}}</span>
                    </a>
                </li>
            @endif
            @if(App\Models\User::getPermission('finance_documents'))
                <li class="vender-menu-item finance-menu-item">
                    <a href="{{route('user.documents', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="finance-icon"></i>
                    </span>
                        <span class="vender-menu-item-text">{{ __('vendor.financeAndDocuments')}}</span>
                    </a>
                </li>
            @endif
            @if(App\Models\User::getPermission('my_objects'))
                <li class="vender-menu-item object-menu-item">
                    <a href="{{route('user.objects', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="object-icon"></i>
                    </span>
                        <span class="vender-menu-item-text">{{ __('vendor.my_objects')}}</span>
                    </a>
                </li>
            @endif
            @if(App\Models\User::getPermission('employees'))
                <li class="vender-menu-item employees-menu-item">
                    <a href="{{route('user.employees', ['locale' => App::getLocale()])}}">
                    <span class="vender-menu-icon">
                        <i class="employees-icon"></i>
                    </span>
                        <span class="vender-menu-item-text">{{ __('vendor.employees')}}</span>
                    </a>
                </li>
            @endif
            <li class="vender-menu-item">
                <form action="{{route('logout')}}" method="post" class="d-flex">
                    @csrf
                    <span class="vender-menu-icon">
                        <i class="log-out-icon"></i>
                    </span>
                    <button type="submit" class="btn logoutBtn"><span class="vender-menu-item-text">{{ __('vendor.log_out')}}</span</button>
                </form>

            </li>
        </ul>
    </div>
</aside>
