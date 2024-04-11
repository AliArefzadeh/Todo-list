<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailVerificationService;
use Illuminate\Http\Request;

class MailController extends Controller
{
    protected $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function sendVerificationEmail(User $user)
    {
        $this->emailVerificationService->sendVerificationEmail($user);

        return response()->json(['message' => 'Verification email sent successfully']);
    }

    public function verifyEmail(User $user, Request $request)
    {

        $result = $this->emailVerificationService->verifyEmail($request,$user);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 401);
        } else {
            return response()->json(['message' => $result['message']]);
        }
    }
}
