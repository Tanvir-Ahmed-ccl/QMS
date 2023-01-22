@component('mail::message')
## Hi {{ $username }}

Thanks for signing up for your {{ config('app.name') }} trial account. <br>
Let’s get you ready to provide an awesome customer experience.


@component('mail::button', ['url' => $link])
Click here to verify your email address
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
