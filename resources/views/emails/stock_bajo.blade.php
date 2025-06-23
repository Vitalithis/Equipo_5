<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alerta de Stock Bajo - Plantas Editha</title>
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
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #fcd34d;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .header {
            background-color: #fef9c3;
            color: #92400e;
            padding: 16px;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 15px;
            margin: 12px 0;
        }

        .highlight {
            color: #b91c1c;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            ⚠️ Alerta de Stock Bajo
        </div>

        <div class="content">
            <p>El producto <span class="highlight">{{ $producto->nombre }}</span> ha alcanzado un nivel crítico de stock.</p>
            <p>Stock actual: <span class="highlight">{{ $producto->stock }}</span> unidades.</p>
            <p>Te recomendamos revisar y reponer este producto desde el panel de administración.</p>
        </div>

        <div class="footer">
            Plantas Editha - Sistema de gestión de inventario
        </div>
    </div>
</body>
</html>
