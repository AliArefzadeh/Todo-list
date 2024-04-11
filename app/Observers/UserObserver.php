<?php

namespace App\Observers;

use App\Http\Controllers\MailController;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
       $sendMail= new MailController();
        $sendMail->index($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        /*if ($user->wasChanged('email_verified_at') && $user->getOriginal('email_verified_at)*/
        if (($user->email_verified_at)) {
            $user->tokens()->update(['abilities'=>'["todo:crud"]']);
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
