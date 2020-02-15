<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">

            @include('includes.admin.sidebar.sidebar-toggle')
            @if(isset($show_sidebar_quick_search)  &&  $show_sidebar_quick_search == true)
                @include('includes.admin.sidebar.sidebar-search')
            @endif

            <li class="nav-item {{ Request::segment(1) == 'home' ? 'active' : '' }}">
                <a href="/home" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ trans('admin.dashboard') }}</span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'categories' ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" class="nav-link nav-toggle">
                    <i class="icon-star"></i>
                    <span class="title">{{ trans('admin.categories') }}</span>
                </a>
            </li>

            <li class="nav-item {{Request::is('product*') ? 'active' : '' }}">
                <a href="{{ route('products.index') }}" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title">{{ trans('admin.products') }}</span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'colors' ? 'active' : '' }}">
                <a href="{{ route('colors.index') }}" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title">{{ trans('admin.colors') }}</span>
                </a>
            </li>


            <li class="nav-item {{ Request::segment(1) == 'ads' ? 'active' : '' }}">
                <a href="{{ route('ads.index') }}" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i>
                    <span class="title">{{ trans('admin.ads') }}</span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'orders' ? 'active' : '' }}">
                <a href="{{ route('orders.index') }}" class="nav-link nav-toggle">
                    <i class="icon-basket"></i>
                    @php $unreadOrders = \App\Models\Order::where('status',0)->count()  @endphp
                    <span class="title">{{ trans('admin.orders') }}
                        @if ($unreadOrders && $unreadOrders > 0)
                            <span class="orders-count-badge">{{ $unreadOrders }}</span>
                        @endif
                    </span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'sales' ? 'active' : '' }}">
                <a href="{{ route('sales.index') }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ trans('admin.sales') }}</span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'users' ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ trans('admin.users') }}</span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'notification' ? 'active' : '' }}">
                <a href="{{ route('notification.form') }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ trans('admin.notifications') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
