@php
    $show_theme_panel = false;
    $show_quick_nav = false;
    $show_sidebar_quick_search = false;
    $show_quick_side_menu = false;
@endphp

<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    @include('includes.admin.partials.header')
</head>
<style>
    .page-header-fixed .page-container {
        margin-top: 0 !important;
    }
    .page-content,
    .page-footer {
        background-color: #291313 !important;
    }
</style>
<!-- END HEAD -->
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<div class="page-wrapper">
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content" style="margin: 0 !important;">
                @include('includes.admin.components.page-header')
                @yield('content')
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    @include('includes.admin.partials.footer')
</div>


@if(isset($show_quick_nav) && $show_quick_nav == true)
    @include('includes.admin.components.quick-nav')
@endif

@include('includes.admin.partials.scripts')
</body>

</html>