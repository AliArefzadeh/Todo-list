<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index(User $user)
    {
        $verificationUrl = \URL::temporarySignedRoute(
            'verify.email', now()->addMinutes(30), ['user' => $user->id]
        );

         \Mail::to($user)->send(new VerifyEmail($verificationUrl));
        //return (new VerifyEmail($verificationUrl));

    }

    public function verifyEmail(User $user, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        elseif ($request->hasValidSignature()) {
            $user->update(['email_verified_at' => now()]);
        }
    }
}
