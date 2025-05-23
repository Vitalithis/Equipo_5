<?php $__env->startSection('title', 'Gestión de Pedidos'); ?>

<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="max-w-7xl mx-auto px-8 py-10 font-['Roboto'] text-gray-800">
    <?php if(session('success')): ?>
        <div id="success-message" class="bg-[#FFF9DB] border-l-4 border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($pedidos->count()): ?>
        <div class="overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
            <table class="min-w-full divide-y divide-eaccent2 text-sm">
                <thead class="bg-eaccent2 text-eprimary uppercase tracking-wide text-xs font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-6 py-4 text-center">ID</th>
                        <th class="px-6 py-4 text-center">Usuario</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-efore font-['Roboto']">
                    <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-efore transition duration-200 cursor-pointer" onclick="toggleDetalles(<?php echo e($pedido->id); ?>)">
                            <td class="px-6 py-4 text-center font-bold text-eprimary"><?php echo e($pedido->id); ?></td>
                            <td class="px-6 py-4 text-center"><?php echo e($pedido->usuario->name); ?></td>
                            <td class="px-6 py-4 text-center">$<?php echo e(number_format($pedido->total, 0, ',', '.')); ?></td>
                            <td class="px-6 py-4 text-center">
                                <?php echo $__env->make('pedidos.partials.estado_form', ['pedido' => $pedido], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span id="icon-<?php echo e($pedido->id); ?>" class="inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary">
                                        <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                    </svg>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="p-0">
                                <div id="detalles-<?php echo e($pedido->id); ?>" class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary">
                                    <div class="p-6 space-y-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <p><strong class="text-eprimary">Método de entrega:</strong> <?php echo e($pedido->metodo_entrega); ?></p>
                                            <p><strong class="text-eprimary">Dirección:</strong> <?php echo e($pedido->direccion ?? 'No disponible'); ?></p>
                                            <p><strong class="text-eprimary">Fecha de pedido:</strong> <?php echo e($pedido->created_at->format('d-m-Y H:i')); ?></p>
                                        </div>

                                        <div>
                                            <p class="font-semibold text-eprimary mb-2">Productos:</p>
                                            <ul class="list-disc list-inside ml-4 space-y-1">
                                                <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <span><?php echo e($detalle->nombre_producto_snapshot); ?></span>
                                                        <span class="text-gray-600">(x<?php echo e($detalle->cantidad); ?>, $<?php echo e(number_format($detalle->precio_unitario, 0, ',', '.')); ?>, Subtotal: $<?php echo e(number_format($detalle->subtotal, 0, ',', '.')); ?>)</span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-4">
                                            <div class="flex items-center gap-2">
                                                <strong class="text-eprimary">Boleta SII:</strong>
                                                <?php if($pedido->boleta_final_path): ?>
                                                    <span class="text-green-600 font-medium">Subida</span>
                                                    <button class="open-modal-pdf text-esecondary hover:text-eaccent text-sm underline"
                                                            data-pdf="<?php echo e(asset('storage/' . $pedido->boleta_final_path)); ?>">
                                                        Ver PDF
                                                    </button>
                                                    <a href="<?php echo e(asset('storage/' . $pedido->boleta_final_path)); ?>"
                                                       target="_blank"
                                                       class="text-sm text-blue-600 hover:text-blue-800 underline ml-2">
                                                        Descargar
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-red-500 font-medium">No subida</span>
                                                <?php endif; ?>

                                                <button class="open-modal-upload text-eaccent hover:text-eaccent2 text-lg"
                                                        data-action="<?php echo e(route('boletas.subir', ['pedido' => $pedido->id])); ?>">
                                                    📤
                                                </button>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <button class="open-modal-provisoria inline-block bg-yellow-100 hover:bg-yellow-200 text-eprimary font-semibold text-sm px-4 py-2 rounded shadow transition"
                                                    data-url="<?php echo e(route('boletas.provisoria', $pedido->id)); ?>">
                                                Ver boleta provisoria
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center text-lg text-gray-600 mt-10">No hay pedidos registrados.</p>
    <?php endif; ?>
</div>


<?php echo $__env->make('pedidos.partials.modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('pedidos.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/pedidos/index.blade.php ENDPATH**/ ?>