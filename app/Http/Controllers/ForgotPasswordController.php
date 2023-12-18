<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use App\Mail\ResetSuccessfullMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.passwords.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return redirect()->route('password.reset.form')->with('error', 'User not found');
        }

        $token = Str::random(32);
        $user->update(['reset_password_token' => $token]);

        // Send the reset link to the user
        $resetLink = route('password.reset.show.form', ['token' => $token]);
        Mail::to($user->email)->send(new ResetPasswordMail($user, $resetLink));

        return redirect()->route('password.reset.form')->with('success', 'Password reset link sent!');
    }

    public function showResetForm($token)
    {
        $user = User::where('reset_password_token', $token)->first();
        
        if (!$user) {
            return redirect()->route('password.reset.form')->with('error', 'Invalid reset token');
        }

        return view('auth.passwords.reset', ['token' => $token, 'email' => $user->email]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->input('email'))
            ->where('reset_password_token', $request->input('token'))
            ->first();

        if (!$user) {
            return redirect()->route('password.reset.form', ['token' => $request->input('token')])
                ->with('error', 'Invalid reset token or email');
        }

        // Update user's password and reset the token
        $user->update([
            'password' => Hash::make($request->input('password')),
            'reset_password_token' => null,
        ]);

        Mail::to($user->email)->send(new ResetSuccessfullMail());

        return redirect()->route('login.form')->with('success', 'Password reset successfully');
    }
}
