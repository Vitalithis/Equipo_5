<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // 👈 asegúrate de importar esto
use App\Mail\ClienteCreado;

class UserObserver
{
    public function created(User $user)
    {
        Log::info('Observer ejecutado para usuario nuevo: ' . $user->email); // ✅

        if ($user->email) {
            Mail::to($user->email)->send(new ClienteCreado($user));
        }
    }
}
