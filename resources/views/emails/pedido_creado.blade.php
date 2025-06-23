<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido confirmado - Plantas Editha</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        body {
            background-color: #f0fdf4;
            font-family: 'Roboto', sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid #bbf7d0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #d1fae5;
            padding-bottom: 20px;
        }

        .header img {
            max-width: 110px;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #047857;
            font-size: 24px;
            margin: 10px 0 0;
        }

        p {
            font-size: 15px;
            margin: 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th {
            background-color: #d1fae5;
            color: #065f46;
            font-weight: 600;
            text-align: left;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
            color: #064e3b;
            text-align: right;
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Plantas Editha!</h1>
        <h1>¡Gracias por tu compra 🌱!</h1>
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
