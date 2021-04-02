@component('mail::message')

    Mã xác minh {{ config('app.name') }},

    Xin chào, {{ $user->name }}

    Đây là mã OTP : {{ $user->activation_token }}

    Cảm ơn. 
@endcomponent