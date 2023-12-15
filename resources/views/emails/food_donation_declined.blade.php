@component('mail::message')
# Food Donation Declined

Your food donation on date {{ $foodDonation->food_donation_date }} has been declined. If you have any questions, please contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
