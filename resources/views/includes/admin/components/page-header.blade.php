<!-- BEGIN PAGE HEADER-->
@if(isset($show_theme_panel) && $show_theme_panel == true)
    @include('includes.admin.components.theme-panel')
@endif

<!-- BEGIN PAGE BAR -->
<div class="page-bar">

    @yield('breadcrumb')

    {{--<div class="page-toolbar">
        <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body"
             data-placement="bottom" data-original-title="Change dashboard date range">
            <i class="icon-calendar"></i>&nbsp;
            <span class="thin uppercase hidden-xs"></span>&nbsp;
            <i class="fa fa-angle-down"></i>
        </div>
    </div>--}}
</div>
<!-- END PAGE BAR -->

@include('includes.admin.components.page-title')

<!-- END PAGE HEADER-->