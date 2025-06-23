<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $clienteId = $validated['cliente_id'];

        // Buscar un usuario con rol admin dentro de ese cliente
        $admin = User::where('cliente_id', $clienteId)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })
            ->first();

        if (!$admin) {
            return back()->with('error', 'No se encontró un administrador para enviar el mensaje.');
        }

        // Enviar el correo al admin
        Mail::raw("Mensaje de contacto:\n\nEmail: {$validated['email']}\nAsunto: {$validated['subject']}\nMensaje:\n{$validated['message']}", function ($message) use ($admin, $validated) {
            $message->to($admin->email)
                ->subject('Nuevo mensaje de contacto: ' . $validated['subject'])
                ->replyTo($validated['email']);
        });

        return back()->with('success', '¡Tu mensaje ha sido enviado con éxito!');
    }
}
