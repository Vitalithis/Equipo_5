<?php $__env->startSection('title', isset($orden) ? 'Editar Orden de Producción' : 'Nueva Orden de Producción'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('dashboard.ordenes')); ?>" class="text-green-700 hover:text-green-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver al listado
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            <?php echo e(isset($orden) ? 'Editar' : 'Nueva'); ?> Orden de Producción
        </h1>
    </div>

    <form method="POST"
          action="<?php echo e(isset($orden) ? route('ordenes.update', $orden->id) : route('ordenes.store')); ?>"
          class="bg-white p-6 rounded-lg shadow space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($orden)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
            <input type="text" name="codigo" id="codigo" required
                   class="form-input mt-1 w-full"
                   value="<?php echo e(old('codigo', $orden->codigo ?? '')); ?>">
        </div>

        <div>
            <label for="producto_id" class="block text-sm font-medium text-gray-700">Producto</label>
            <select name="producto_id" id="producto_id" required class="form-select mt-1 w-full">
                <option value="">Selecciona un producto</option>
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($producto->id); ?>"
                        <?php echo e(old('producto_id', $orden->producto_id ?? '') == $producto->id ? 'selected' : ''); ?>>
                        <?php echo e($producto->nombre); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" required min="1"
                   class="form-input mt-1 w-full"
                   value="<?php echo e(old('cantidad', $orden->cantidad ?? '')); ?>">
        </div>

        <div>
            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" required
                   class="form-input mt-1 w-full"
                   value="<?php echo e(old('fecha_inicio', isset($orden) ? $orden->fecha_inicio : now()->toDateString())); ?>">
        </div>

        <div>
            <label for="fecha_fin_estimada" class="block text-sm font-medium text-gray-700">Fecha Estimada de Fin</label>
            <input type="date" name="fecha_fin_estimada" id="fecha_fin_estimada"
                   class="form-input mt-1 w-full"
                   value="<?php echo e(old('fecha_fin_estimada', $orden->fecha_fin_estimada ?? '')); ?>">
        </div>

        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            <select name="estado" id="estado" class="form-select mt-1 w-full" required>
                <?php
                    $estadoActual = old('estado', $orden->estado ?? 'pendiente');
                ?>
                <?php $__currentLoopData = ['pendiente', 'en proceso', 'completada']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($estado); ?>" <?php echo e($estado === $estadoActual ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst($estado)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Trabajador asignado</label>
            <select name="user_id" id="user_id" class="form-select mt-1 w-full">
                <option value="">Selecciona un trabajador</option>
                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($usuario->id); ?>"
                        <?php echo e(old('user_id', $orden->user_id ?? '') == $usuario->id ? 'selected' : ''); ?>>
                        <?php echo e($usuario->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
            <textarea name="observaciones" id="observaciones" rows="3"
                      class="form-textarea mt-1 w-full"><?php echo e(old('observaciones', $orden->observaciones ?? '')); ?></textarea>
        </div>

        <div class="flex justify-end gap-4">
            <a href="<?php echo e(route('dashboard.ordenes')); ?>"
               class="px-4 py-2 border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50">
               Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                <?php echo e(isset($orden) ? 'Actualizar' : 'Crear'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/ordenes_edit.blade.php ENDPATH**/ ?>