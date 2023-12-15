@component('mail::message')
# Food Donation Accepted

Your food donation on date {{ $foodDonation->food_donation_date }} has been accepted. Thank you for your contribution!

@component('mail::button', ['url' => route('food.donation.history')])
View Details
@endcomponent

If you have any questions, please contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
