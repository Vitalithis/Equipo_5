<?php

namespace App\Observers;

use App\Models\User;
namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClienteCreado; // Usa el archivo que ya creaste

class UserObserver
{
    public function created(User $user)
    {
        if ($user->email) {
            Mail::to($user->email)->send(new ClienteCreado($user));
        }
    }



    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
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
