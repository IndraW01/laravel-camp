@component('mail::message')

# Register Camp {{ $checkout->camp->title }}

Hi, {{ $checkout->user->name }}
<br>
Thank you for register on <b>{{ $checkout->camp->title }}, please see payment instruction by click the button below.</b>

@component('mail::button', ['url' => route('user.dashboard')])
My Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
