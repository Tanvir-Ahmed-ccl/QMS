@component('mail::message')
## Hello!

Your two factor authenticaion code is given below -

@component('mail::panel')
<span style="text-align: center; display:block; font-size: 22px; margin: 0; font-weight:bolder">{{$otp}}</span>
@endcomponent

The code will expire in 10 minutes.

If you have not tried to login, ignore this message.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
