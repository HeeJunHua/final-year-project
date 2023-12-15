<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Models\Notification;

class VerificationController extends Controller
{
    public function verify(Request $request, $token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return view('verification.invalid');
        }

        if ($user->hasVerifiedEmail()) {
            return view('verification.already-verified');
        }

        $user->markEmailAsVerified();

        event(new Verified($user));


        $title = "Email Verification Succeed";
        $content = "Your email has been successfully verified";
        Notification::createNotification($user, $title, $content);

        return view('verification.success');
    }
}
