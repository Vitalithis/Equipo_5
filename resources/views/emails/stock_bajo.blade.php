<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Stock Bajo</title>
</head>
<body>
    <h1>⚠️ Alerta de Stock Bajo</h1>
    <p>El producto <strong>{{ $producto->nombre }}</strong> tiene un stock crítico: <strong>{{ $producto->stock }}</strong>.</p>
    <p>Revisa y repón el stock desde el panel de administración.</p>
</body>
</html>
