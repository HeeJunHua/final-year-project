<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller {
    public function paymenterror(string $message = null) {
        if($message) {
            return redirect()
                ->route('fundraise_home_page')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('fundraise_home_page')
                ->with('error', $message ?? 'Something went wrong.');
        }
    }

    public function paymentCancel() {
        return redirect()->route('fundraise_home_page')->with('error', 'Transaction has been cancelled');
    }

    public function paymentSuccess(Request $request) {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            if(isset($response['purchase_units'][0]['reference_id'])) {
                return redirect($this->donationsuccess($response['purchase_units'][0]['reference_id']));
            } else {
                return redirect()->route('fundraise_home_page')->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } else {
            return redirect()->route('fundraise_home_page')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
}
