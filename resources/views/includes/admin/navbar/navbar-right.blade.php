<ul class="nav navbar-nav pull-right">
    @include('includes.admin.navbar.localization')
    @include('includes.admin.navbar.user-login')
    @if(isset($show_quick_side_menu)  &&  $show_quick_side_menu == true)
        @include('includes.admin.navbar.quick-sidebar-toggle')
    @endif
</ul>