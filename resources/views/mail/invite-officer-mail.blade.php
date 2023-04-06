@component('mail::message')
## Hello {{ $data['username'] }}

An account has been created at <strong>{{$data['company_name']}}</strong> in <a href="{{$data['baseUrl']}}">{{ config('app.name') }}</a>.

By using these credentials, you can login to <a href="{{$data['loginUrl']}}">{{$data['loginUrl']}}</a>.

<br>

<b>Email:</b> {{$data['email']}} <br>
<b>Password:</b> {{$data['password']}}

<br>

To secure your account, we recommend changing your password in your panel.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
