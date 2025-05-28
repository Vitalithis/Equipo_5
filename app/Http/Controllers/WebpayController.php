<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Transbank\Webpay\WebpayPlus\Transaction;


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
    $cart = session('cart', []);

    if (empty($cart)) {
        return redirect()->route('checkout.index')->with('error', 'Tu carrito está vacío.');
    }

    $amount = collect($cart)->sum(fn($item) => (int)$item['precio_unitario'] * (int)$item['cantidad']);

    $buyOrder  = uniqid('order_');
    $sessionId = session()->getId();
    $returnUrl = route('webpay.respuesta');

    $transaction = new Transaction();
    $response = $transaction->create($buyOrder, $sessionId, $amount, $returnUrl);

    // Guarda carrito y datos temporales en sesión
    session()->put('carrito_pago', $cart);
    session()->put('buy_order', $buyOrder);
    session()->put('monto_total', $amount);
    session()->put('metodo_entrega', $request->input('metodo_entrega', 'retiro'));
    session()->put('direccion_entrega', $request->input('metodo_entrega') === 'domicilio' ? $request->input('direccion_entrega') : null);

    return redirect($response->getUrl() . '?token_ws=' . $response->getToken());
}



    // Recibe la respuesta de Webpay
   public function respuesta(Request $request)
{
    $token = $request->get('token_ws');

    if (!$token) {
        return redirect()->route('checkout.index')->with('error', 'Transacción cancelada.');
    }

    $transaction = new Transaction();
    $result = $transaction->commit($token);

    if ($result->isApproved()) {
        $user = auth()->user();
        $cart = session('carrito_pago', []);
        $total = session('monto_total');

        $pedido = Pedido::create([
            'usuario_id' => $user->id,
            'total' => $total,
            'estado_pedido' => 'pendiente',
            'metodo_entrega' => 'retiro', // ajusta según tu flujo real
        ]);

        foreach ($cart as $item) {
            $pedido->productos()->attach($item['producto_id'], [
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'subtotal' => $item['cantidad'] * $item['precio_unitario'],
                'nombre_producto_snapshot' => $item['nombre'],
                'codigo_barras_snapshot' => $item['codigo_barras'],
                'imagen_snapshot' => $item['imagen'],
            ]);
        }

        session()->forget(['carrito_pago', 'buy_order', 'monto_total', 'cart']);

        return redirect()->route('checkout.index')->with('success', 'Pago exitoso. Pedido registrado.');
    }

    return redirect()->route('checkout.index')->with('error', 'Pago rechazado.');
}

}
