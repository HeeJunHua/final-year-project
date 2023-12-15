<?php

namespace App\Http\Controllers;

use App\Jobs\ReceiptEmail;
use App\Jobs\ThankYouEmail;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Point;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function paypal(string $amount, string $currency, string $id) {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "reference_id" => $id,
                    "amount" => [
                        "currency_code" => "MYR",
                        "value" => $amount
                    ]
                ]
            ]
        ]);

        if(isset($response['id']) && $response['id'] != null) {
            foreach($response['links'] as $links) {
                if($links['rel'] == 'approve') {
                    return $links['href'];
                }
            }
            return route('paymenterror');
        } else {
            return route('paymenterror', ['message' => $response['message']]);
        }
    }

    //paymentsuccess
    public function donationsuccess(string $id) {
        $payment = Payment::find($id);

        // new record
        $record = new Donation();

        //update field
        $record->event_id = $payment->event_id;
        $record->user_id = $payment->user_id;
        $record->points_earned = $payment->points_earned;
        $record->donation_amount = $payment->donation_amount;
        $record->payment_method = $payment->payment_method;
        $record->donation_date = $payment->donation_date;
        $record->name = $payment->name;
        $record->phone = $payment->phone;
        $record->email = $payment->email;

        //save
        $record->save();

        $payment->status = 1;
        $payment->update();

        // new record
        $point = new Point();

        //update field
        $point->event_id = $record->event_id;
        $point->user_id = $record->user_id;
        $point->donation_id = $record->id;
        $point->redemption_id = null;
        $point->point = floor($record->donation_amount / 10);
        $point->transaction_type = "CR";

        //save
        $point->save();

        //email
        // Mail::to($record->email)->send(new ReceiptMail($record));
        ReceiptEmail::dispatch($record->email, $record);

        $event = Event::find($record->event_id);
        $goal = $event->target_goal;
        $total = Donation::where('event_id', $record->event_id)->sum('donation_amount');

        if($total >= $goal) {
            //thank you email
            $this->thankyou($record->event_id);
        }

        //return url for js to redirect, redirect to global function = user.redirect
        return route('event.receipt', ['id' => $record->id]);
    }

    public function thankyou(string $id) {
        $event = Event::find($id);
        $record = Donation::where('event_id', $id)->pluck('email','email');
        
        if($record->isNotEmpty()) {
            // Send a single email to all unique email addresses
            foreach($record as $value) {
                //queue email
                ThankYouEmail::dispatch($value, $event->event_name);
            }
        }
    }
}
