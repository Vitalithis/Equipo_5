<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus\Transaction;
use Transbank\Webpay\WebpayPlus\WebpayPlus;

class CheckoutController extends Controller
{
    public function pay(Request $request)
    {
        $amount = $request->input('amount');
        $sessionId = uniqid();
        $buyOrder = uniqid('ORDER_');
        $returnUrl = route('checkout.response');

        $response = (new Transaction)->create(
            $buyOrder,
            $sessionId,
            $amount,
            $returnUrl
        );

        // Redirigir a Webpay
        return redirect()->away($response->getUrl() . '?token_ws=' . $response->getToken());
    }

    public function response(Request $request)
    {
        $token = $request->input('token_ws');

        if (!$token) {
            return redirect()->route('checkout.cancel');
        }

        $response = (new Transaction)->commit($token);

        if ($response->isApproved()) {
            // Aquí podrías guardar la orden, limpiar el carrito, etc.
            session()->forget('cart');
            return view('checkouts.success', ['response' => $response]);
        } else {
            return redirect()->route('checkout.cancel');
        }
    }

    public function cancel()
    {
        return view('checkouts.cancel');
    }
}
