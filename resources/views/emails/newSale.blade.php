@component('mail::message')
# welcome {{ $sale->name }}

you have been registered as sale in {{ config('app.name') }} and this is your login credentials.

# email : {{ $sale->email }}
# password : {{ $password }}

please consider changing the password as soon as this email finds you

Thanks,<br>
{{ config('app.name') }}
@endcomponent
