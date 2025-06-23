<?php
namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ClienteCreado extends Mailable
{
    use Queueable, SerializesModels;

    public $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }

public function build()
{
    return $this->subject('Registro Exitoso')
                ->view('emails.cliente_creado')
                ->with([
                    'nombre' => $this->user->name,
                ]);
}

}
