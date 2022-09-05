@component('mail::message')
Our registration is successful!

@component('mail::button', ['url' => route('login')])
Login and Start something new, {{ $user->name }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
