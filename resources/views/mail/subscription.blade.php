@component('mail::message')
## Hi {{ $username }}

Thanks for subscribing. <br>
Let's get you ready to provide an awesome customer experience.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
