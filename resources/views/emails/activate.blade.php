@extends('layouts.email')

@section('content')

    @component('emails.plugin.greeting') Hello, {{ $data['name'] }} @endcomponent

    @component('emails.plugin.paragraph')
        Thanks for getting started with Shehata-tires !
        please follow the below link to activate your account
    @endcomponent

    @component('emails.plugin.button', ['bg_color' => '#54280d', 'color' => '#FFF', 'link' => url('/user/' . $data['id'] . '/' . Carbon\Carbon::now()->addHour()->timestamp . '/activate') ])
        Activate
    @endcomponent

    @component('emails.plugin.signature') Shehata-tires Support @endcomponent
@stop

@section('copy', 'RKanjel - All Right Reserved.')

