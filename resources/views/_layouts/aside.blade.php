<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item {{ request()->is('dashboard') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/dashboard') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-home"></i>
                    <span class="kt-menu__link-text">Dashboard</span>
                </a>
            </li>
            <li class="kt-menu__section">
                <h4 class="kt-menu__section-text">Customer</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <!-- @if(in_array(session('user')['user_type_name'], array('Dealer')))
            <li class="kt-menu__item {{ request()->is('new-customer') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/manage-customer/create') }}" class="kt-menu__link">
                    <i class="kt-menu__link-icon flaticon-user-add"></i>
                    <span class="kt-menu__link-text">New Customer</span>
                </a>
            </li>
            @endif -->
            <li class="kt-menu__item {{ request()->is('all-customers') || request()->is('view-customer') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-customers') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-users"></i>
                    <span class="kt-menu__link-text">All Customers</span>
                   <!--  <span class="kt-menu__link-badge"><span class="kt-badge kt-badge--rounded kt-badge--brand">1</span></span> -->
                </a>
            </li>
             <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Project</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @if(in_array(session('user')['user_type_name'], array('Dealer')))
            <li class="kt-menu__item {{ request()->is('manage-project/create') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/manage-project/create') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-folder-4"></i>
                    <span class="kt-menu__link-text">New Project</span>
                </a>
            </li>
            @endif
            <li class="kt-menu__item {{ request()->is('all-projects') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-projects') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-folder-1"></i>
                    <span class="kt-menu__link-text">All Projects</span>
                </a>
            </li>

            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Pricing</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @if(in_array(session('user')['user_type_name'], array('Administrator')))
            <li class="kt-menu__item {{ request()->is('price-confirmation') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/price-confirmation') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-price-tag"></i>
                    <span class="kt-menu__link-text">Price Confirmation</span>
                </a>
            </li>
            @endif
            <li class="kt-menu__item {{ request()->is('all-price-confirmation') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-price-confirmation') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-interface-9"></i>
                    <span class="kt-menu__link-text">All Price Confirmation</span>
                </a>
            </li>
            @if(in_array(session('user')['user_type_name'], array('Administrator')))
            <li class="kt-menu__item {{ request()->is('fpc-details/validate') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/fpc-approval') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-price-tag"></i>
                    <span class="kt-menu__link-text">Approval</span>
                    <span class="kt-menu__link-badge">
                        <span class="kt-badge kt-badge--rounded kt-badge--primary">5</span>
                    </span>
                </a>
            </li>
            @endif
            <li class="kt-menu__item {{ request()->is('all-fwpc') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-fwpc') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-interface-9"></i>
                    <span class="kt-menu__link-text">All FWPC</span>
                </a>
            </li>

            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Purchase Order</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>

      <!--       <li class="kt-menu__item {{ request()->is('po-entry') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/po-entry') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-price-tag"></i>
                    <span class="kt-menu__link-text">Purchase Order Entry</span>
                </a>
            </li> -->
      
            <li class="kt-menu__item {{ request()->is('all-purchase-order') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-po') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-interface-9"></i>
                    <span class="kt-menu__link-text">All Purchase Order</span>
                </a>
            </li>
        </ul>
    </div>
</div>