@component('mail::message')
# Password Reset

Hello {{ $user->name }},

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $resetLink])
Reset Password
@endcomponent

If you did not request a password reset, no further action is required.

Thanks,
{{ config('app.name') }}
@endcomponent
