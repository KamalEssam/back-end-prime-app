<meta charset="utf-8"/>
<title>{{ ucfirst(trans('admin.dashboard')) }} | @yield('title') </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="Preview page of Metronic Admin Theme #1 for statistics, charts, recent events and reports"
      name="description"/>
<meta content="" name="author"/>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
      type="text/css"/>
{{ Html::style('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}
{{ Html::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}



@if(app()->getLocale() == 'ar')

    {{ Html::style('assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css') }}
    {{ Html::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css') }}
    {{ Html::style('assets/global/css/components-rtl.min.css') }}
    {{ Html::style('assets/global/css/plugins-rtl.min.css') }}
    {{ Html::style('assets/layouts/layout/css/layout-rtl.min.css') }}
    {{ Html::style('assets/layouts/layout/css/themes/darkblue-rtl.min.css') }}
    {{ Html::style('assets/global/plugins/datatables/datatables.min.css') }}
    {{ Html::style('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css') }}
    {{ Html::style('assets/apps/css/main-rtl.css') }}
@else

    {{ Html::style('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}
    {{ Html::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}
    {{ Html::style('assets/global/css/components.min.css') }}
    {{ Html::style('assets/global/css/plugins.min.css') }}
    {{ Html::style('assets/layouts/layout/css/layout.min.css') }}
    {{ Html::style('assets/layouts/layout/css/themes/darkblue.min.css') }}
    {{ Html::style('assets/global/plugins/datatables/datatables.min.css') }}
    {{ Html::style('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}
    {{ Html::style('assets/apps/css/main.css') }}

@endif

{!! Html::style('assets/global/plugins/sweetalert/sweetalert.css') !!}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/css/iziModal.css">

@yield('page-styles')



<!-- END THEME LAYOUT STYLES -->
<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}"/>
