<!DOCTYPE html>

<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<title>premieg | @yield('title') </title>


<head>
    @include('includes.admin.partials.login.header')
</head>
<!-- END HEAD -->

<body class=" login">


@include('includes.admin.components.login-logo')

<!-- BEGIN LOGIN -->
<div class="content">
    @yield('content')
</div>
<!-- END LOGIN -->

@include('includes.admin.partials.login.footer')

@include('includes.admin.partials.login.scripts')


</body>

</html>
