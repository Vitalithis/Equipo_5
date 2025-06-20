<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido confirmado - Plantas Editha</title>
    <style>
        body { background-color: #fdf9f6; font-family: Arial, sans-serif; color: #444; margin: 0; padding: 0; }
        .container { max-width: 700px; margin: 30px auto; background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .header img { max-width: 120px; margin-bottom: 10px; }
        h1 { font-weight: normal; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
        .total { font-weight: bold; font-size: 18px; text-align: right; margin-top: 20px; }
        .footer { margin-top: 40px; font-size: 12px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://plantaseditha.com/logo.png" alt="Plantas Editha">
            <h1>¡Gracias por tu compra!</h1>
        </div>

        <p>Hola {{ $pedido->usuario->name }},</p>
        <p>Hemos recibido tu pedido <strong>#{{ $pedido->id }}</strong>. Aquí tienes un resumen:</p>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->nombre_producto_snapshot }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">Total: ${{ number_format($pedido->total, 0, ',', '.') }}</div>

        <div class="footer">
            <p>Este correo es automático. No respondas directamente.</p>
            <p>&copy; {{ date('Y') }} Plantas Editha</p>
        </div>
    </div>
</body>
</html>
