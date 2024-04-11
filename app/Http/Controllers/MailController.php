<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\EmailVerificationService;

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

