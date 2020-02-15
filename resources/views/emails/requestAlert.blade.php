@extends('layouts.email')

@section('content')

    @component('emails.plugin.greeting') Hello, Premi @endcomponent

    @component('emails.plugin.paragraph')
        You have new order from {{ $data['name'] }} <br>
        please click on the button blow to see the full request
    @endcomponent


    @component('emails.plugin.button', ['bg_color' => '#000', 'color' => '#FFF', 'link' => route('orders.show',$data['id']) ])
        view order
    @endcomponent

    @component('emails.plugin.signature') Premi Support @endcomponent
@stop

@section('copy', 'RKanjel - All Right Reserved.')

