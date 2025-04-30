<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta Electrónica</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            color: #1f2937;
            padding: 2rem;
        }
        .header {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .table th, .table td {
            border: 1px solid #e5e7eb;
            padding: 0.5rem;
            text-align: left;
        }
        .table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">Boleta Electrónica</div>

    <p><span class="section-title">ID del Pedido:</span> {{ $pedido->id }}</p>
    <p><span class="section-title">Nombre:</span> {{ $pedido->nombre }}</p>
    <p><span class="section-title">Estado:</span> {{ ucfirst($pedido->estado) }}</p>
    <p><span class="section-title">Fecha de Creación:</span> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ID</td>
                <td>{{ $pedido->id }}</td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td>{{ $pedido->nombre }}</td>
            </tr>
            <tr>
                <td>Estado</td>
                <td>{{ ucfirst($pedido->estado) }}</td>
            </tr>
            <tr>
                <td>Fecha</td>
                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Este documento es una representación no oficial de la boleta para uso del cliente.
    </div>
</body>
</html>
