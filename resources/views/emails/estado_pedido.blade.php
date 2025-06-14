<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de tu pedido - Plantas Editha</title>
    <style>
        body {
            background-color: #fdf9f6;
            font-family: 'Arial', sans-serif;
            color: #444;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }
        h1 {
            font-weight: normal;
            letter-spacing: 1px;
            color: #555;
        }
        .status-box {
            background-color: #faf3e0;
            border: 1px solid #eedcbd;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin: 30px 0;
        }
        .status {
            color: #aa8453;
            font-size: 22px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .total {
            font-weight: bold;
            font-size: 18px;
            color: #333;
            text-align: right;
            margin-top: 20px;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h4>"Plantas Editha"</h1>
        <h1>Gracias por tu compra</h1>
    </div>

    <p>Hola {{ $pedido->usuario->name }},</p>
    <p>El estado de tu pedido <strong>#{{ $pedido->id }}</strong> ha sido actualizado:</p>

    <div class="status-box">
        <div class="status">{{ $pedido->estadoFormateado() }}</div>
    </div>

    <h3>Detalle de tu pedido</h3>
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
                    <td>

                        {{ $detalle->nombre_producto_snapshot }}
                    </td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total: ${{ number_format($pedido->total, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Plantas Editha - Este correo es automático, no responder directamente.</p>
        <p>&copy; {{ date('Y') }} Plantas Editha</p>
    </div>
</div>
</body>
</html>
