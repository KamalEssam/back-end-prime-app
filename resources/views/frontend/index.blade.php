@extends('layouts.admin.guest')
@section('content')
    <style>
        .login {
            background-color: #252525 !important;
        }

        .page-content, .page-footer {
            background-color: #fff !important;
        }

        .alert-success {
            background-color: #c5efdf;
            border-color: #c5efdf;
            color: #1d8849;
        }

        .center-screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
        }

    </style>
    <div class="container">
        <div class="center-screen">
            <div class="text-center">
                @include('includes.admin.components.login-logo')
            </div>
            <h2 class="alert alert-{{ ($alert) ?? 'info' }}">
                {{ ($message) ?? 'welcome to premi shop' }}
            </h2>
            <br>
            <br>
            <br>
        </div>
    </div>
@stop
