<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus\Transaction;

class WebpayController extends Controller
{
    public function pagar()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $transaction = new Transaction();

        $response = $transaction->create(
            uniqid(), // buyOrder
            uniqid(), // sessionId
            $total,
            route('webpay.confirm') // URL de retorno
        );

        return redirect($response->getUrl() . '?token_ws=' . $response->getToken());
    }

    public function confirmar(Request $request)
    {
        $token = $request->get('token_ws');

        $transaction = new Transaction();
        $response = $transaction->commit($token);

        if ($response->isApproved()) {
            // Procesar orden, limpiar carrito, guardar venta, etc.
            session()->forget('cart');
            return redirect()->route('home')->with('success', 'Pago aprobado con Webpay');
        }

        return redirect()->route('home')->with('error', 'Pago rechazado');
    }
}


