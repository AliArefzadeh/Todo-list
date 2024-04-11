<?php

namespace App\Services;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailVerificationService
{
    public function sendVerificationEmail(User $user)
    {
        $verificationUrl = url()->temporarySignedRoute(
            'verify.email', now()->addMinutes(30), ['user' => $user->id]
        );

        Mail::to($user)->send(new VerifyEmail($verificationUrl));
    }

    public function verifyEmail(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return ['error' => 'Invalid signature'];
        }

        $user = User::findOrFail($request->user);
        $user->update(['email_verified_at' => now()]);

        return ['message' => 'Email verified successfully'];
    }
}

