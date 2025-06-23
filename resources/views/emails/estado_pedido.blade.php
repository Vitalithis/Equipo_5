<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estado de tu pedido - Plantas Editha</title>
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

        .header h1 {
            color: #047857;
            font-size: 24px;
            margin: 10px 0 0;
        }

        .header h4 {
            color: #10b981;
            margin: 0;
            font-size: 16px;
        }

        .status-box {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin: 30px 0;
        }

        .status {
            color: #047857;
            font-size: 22px;
            font-weight: bold;
        }

        h3 {
            color: #065f46;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #d1fae5;
            color: #065f46;
            text-align: left;
        }

        th, td {
            padding: 10px;
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
        <h4>Plantas Editha</h4>
        <h1>Gracias por tu compra 🌱</h1>
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
                    <td>{{ $detalle->nombre_producto_snapshot }}</td>
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
        <p>Este correo es automático, por favor no respondas directamente.</p>
        <p>&copy; {{ date('Y') }} Plantas Editha</p>
    </div>
</div>
</body>
</html>
