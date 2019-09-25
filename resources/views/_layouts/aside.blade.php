<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            @if(in_array(session('user')['user_type_id'], array(27,31,32,33)))
            <li class="kt-menu__item {{ request()->is('dashboard') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/dashboard') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-home"></i>
                    <span class="kt-menu__link-text">Dashboard</span>
                </a>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(27,31,32,33)))
            <li class="kt-menu__section">
                <h4 class="kt-menu__section-text">Customer</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="kt-menu__item {{ request()->is('all-customers') || request()->is('view-customer') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-customers') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-users"></i>
                    <span class="kt-menu__link-text">Customers</span>
                   <!--  <span class="kt-menu__link-badge"><span class="kt-badge kt-badge--rounded kt-badge--brand">1</span></span> -->
                </a>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(27,31,32,33))) 
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Project</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(27)))
            <li class="kt-menu__item {{ request()->is('manage-project/create') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/manage-project/create') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-folder-4"></i>
                    <span class="kt-menu__link-text">New Project</span>
                </a>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(27,31,32,33))) 
            <li class="kt-menu__item {{ request()->is('all-projects') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-projects') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-folder-1"></i>
                    <span class="kt-menu__link-text">Projects</span>
                </a>
            </li>
            <li class="kt-menu__item {{ request()->is('all-purchase-order') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-po') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-shopping-cart"></i>
                    <span class="kt-menu__link-text">Purchase Orders</span>
                </a>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(31,32,33))) 
            <li class="kt-menu__item {{ request()->is('project-approval') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/approval-list') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-users"></i>
                    <span class="kt-menu__link-text">Approval</span>
                </a>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(27,31,32,33,38)))
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Pricing</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(32,33)))
            <li class="kt-menu__item {{ request()->is('price-confirmation') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/price-confirmation') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-price-tag"></i>
                    <span class="kt-menu__link-text">Create FPC</span>
                </a>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(32,33)))
            <li class="kt-menu__item {{ request()->is('all-price-confirmation') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/all-price-confirmation') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-crisp-icons"></i>
                    <span class="kt-menu__link-text">FPC</span>
                </a>
            </li>
            @endif 
            @if(in_array(session('user')['user_type_id'], array(27,31,32,33,38)))
            <li class="kt-menu__item {{ request()->is('fwpc-list') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/fwpc-list') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-paper"></i>
                    <span class="kt-menu__link-text">FWPC</span>
                </a>
            </li>
            @endif
            @if(in_array(session('user')['user_type_id'], array(32,33)))
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">SETTINGS</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @endif  
            @if(in_array(session('user')['user_type_id'], array(32,33)))
            <li class="kt-menu__item {{ request()->is('users') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/user-list') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-users-1"></i>
                    <span class="kt-menu__link-text">Users</span>
                </a>
            </li>
            @endif
           <!--  @if(in_array(session('user')['user_type_id'], array(32,33)))
            <li class="kt-menu__item {{ request()->is('approvers') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/fwpc-list') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-user-settings"></i>
                    <span class="kt-menu__link-text">Approvers</span>
                </a>
            </li>
            @endif  -->
           <!--  @if(in_array(session('user')['user_type_id'], array(32,33)))
            <li class="kt-menu__item {{ request()->is('signatories') ? 'kt-menu__item--active' : ''}}" aria-haspopup="true">
                <a href="{{ url('/fwpc-list') }}" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-edit-1"></i>
                    <span class="kt-menu__link-text">Signatories</span>
                </a>
            </li>
            @endif -->     
        </ul>
    </div>
</div>