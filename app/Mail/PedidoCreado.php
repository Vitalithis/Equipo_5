<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;
use App\Models\Pedido;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoCreado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido->load('detalles');
    }

    public function build()
    {
        return $this->subject('Tu pedido ha sido creado')
                    ->view('emails.pedido_creado');
    }
}