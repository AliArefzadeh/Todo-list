<?php

namespace App\Observers;

use App\Models\User;
use App\Services\EmailVerificationService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    private $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function created(User $user)
    {
        // Send verification email
        $this->emailVerificationService->sendVerificationEmail($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if (($user->email_verified_at)) {
            $user->tokens()->update(['abilities' => '["todo:crud"]']);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
