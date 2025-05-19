<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Transbank\Webpay\WebpayPlus\Transaction;
use Transbank\Webpay\WebpayPlus\WebpayPlus;

class WebpayController extends Controller
{
    public function __construct()
    {
        // Configura WebpayPlus usando el config/transbank.php
        WebpayPlus::configureForIntegration('597055555532', '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C');
    }

    // Inicia la transacción
    public function pagar(Request $request)
{
    $userId = auth()->id();
    $items = CartItem::where('user_id', $userId)->get();

    // Convertir monto total a entero
    $amount = $items->sum(fn($i) => (int)$i->precio_unitario * (int)$i->cantidad);
    $amount = intval($amount); // adicional por seguridad


    if ($amount <= 0) {
        return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
    }

    $buyOrder  = uniqid('order_');
    $sessionId = session()->getId();
    $returnUrl = route('webpay.respuesta');

    $transaction = new Transaction();
    $response = $transaction->create($buyOrder, $sessionId, $amount, $returnUrl);

    return redirect($response->getUrl() . '?token_ws=' . $response->getToken());
}


    // Recibe la respuesta de Webpay
    public function respuesta(Request $request)
    {
        $token = $request->get('token_ws');
        if (! $token) {
            return redirect()->route('cart.index')->with('error', 'Transacción cancelada.');
        }

        $transaction = new Transaction();
        $result = $transaction->commit($token);

        if ($result->isApproved()) {
            // Aquí puedes marcar los CartItem como comprados o vaciar el carrito
            CartItem::where('user_id', auth()->id())->delete();

            return redirect()->route('cart.index')
                             ->with('success', 'Pago exitoso. Orden: ' . $result->getBuyOrder());
        }

        return redirect()->route('cart.index')->with('error', 'Pago rechazado.');
    }
}
