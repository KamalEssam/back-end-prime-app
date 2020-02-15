@extends('layouts.email')
@section('content')
    @component('emails.plugin.greeting') Hello, {{ $data['name'] }} @endcomponent
    @component('emails.plugin.paragraph')
        Thanks for getting started with Premieg !
        please follow the below link to set new password for your account
    @endcomponent
    @component('emails.plugin.button', ['bg_color' => '#e41729', 'color' => '#FFF', 'link' => url('/user/' . $data['id'] . '/set-password/' . $data['pin']) ])
        set password
    @endcomponent
    @component('emails.plugin.signature') Premieg Support @endcomponent
@stop
@section('copy', 'RKanjel - All Right Reserved.')
