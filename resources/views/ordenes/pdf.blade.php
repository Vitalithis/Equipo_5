<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes de Producción</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Listado de Órdenes de Producción</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Fecha Inicio</th>
                <th>Fecha Estimada</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenes as $orden)
                <tr>
                    <td>{{ $orden->codigo }}</td>
                    <td>{{ $orden->producto->nombre ?? '-' }}</td>
                    <td>{{ $orden->cantidad }}</td>
                    <td>{{ \Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y') }}</td>
                    <td>{{ $orden->fecha_fin_estimada ? \Carbon\Carbon::parse($orden->fecha_fin_estimada)->format('d/m/Y') : '-' }}</td>
                    <td>{{ ucfirst($orden->estado) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
