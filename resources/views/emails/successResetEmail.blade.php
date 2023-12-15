@component('mail::message')
# Password Reset Successful

Your password has been successfully reset.

Thank you!

@component('mail::button', ['url' => route('login.form')])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent