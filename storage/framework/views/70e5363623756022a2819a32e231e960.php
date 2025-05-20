<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta Pedido #<?php echo e($pedido->id); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #4CAF50;
        }
        .company-info {
            font-size: 10px;
            color: #777;
        }
        .section-title {
            background-color: #4CAF50;
            color: #fff;
            padding: 5px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .summary {
            margin-top: 10px;
            text-align: right;
        }
        .summary p {
            margin: 2px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Vivero Plantas Editha</h1>
        <p class="company-info">
            RUT: 12.345.678-9 | Av. Pedro Aguirre Cerda 2999, San Pedro de la Paz | +56 9 1234 5678
        </p>
    </div>

    <div>
        <div class="section-title">Datos del Pedido</div>
        <p><strong>Fecha:</strong> <?php echo e($pedido->created_at->format('d-m-Y H:i')); ?></p>
        <p><strong>N° Pedido:</strong> <?php echo e($pedido->id); ?></p>
        <p><strong>Cliente:</strong> <?php echo e($pedido->usuario->name); ?></p>
        <p><strong>Método de entrega:</strong> <?php echo e($pedido->metodo_entrega); ?></p>
        <p><strong>Dirección:</strong> <?php echo e($pedido->direccion ?? 'No disponible'); ?></p>
    </div>

    <div>
        <div class="section-title">Productos</div>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">Precio Unitario</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($detalle->nombre_producto_snapshot); ?></td>
                        <td class="text-right"><?php echo e($detalle->cantidad); ?></td>
                        <td class="text-right">$<?php echo e(number_format($detalle->precio_unitario, 0, ',', '.')); ?></td>
                        <td class="text-right">$<?php echo e(number_format($detalle->subtotal, 0, ',', '.')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="summary">
        <p><strong>Subtotal:</strong> $<?php echo e(number_format($subtotal, 0, ',', '.')); ?></p>
        <p><strong>Descuento (10%):</strong> -$<?php echo e(number_format($descuento, 0, ',', '.')); ?></p>
        <p><strong>Total Final:</strong> $<?php echo e(number_format($totalFinal, 0, ',', '.')); ?></p>
    </div>

    <div class="footer">
        Gracias por su compra<br>
        Documento generado electrónicamente - No requiere firma ni timbre
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/boletas/pdf.blade.php ENDPATH**/ ?>