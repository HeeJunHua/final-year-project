@component('mail::message')
# Welcome to Fundraising & Food Waste Reduction System

Thanks for signing up! To complete your registration, please click the button below to verify your email address:

@component('mail::button', ['url' => $verificationUrl])
Verify Email
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
