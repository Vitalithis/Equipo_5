

<?php $__env->startSection('title', 'Editar cuidado'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('dashboard.cuidados')); ?>" class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            <?php echo e(isset($cuidado->id) ? 'Editar' : 'Nuevo'); ?> cuidado
        </h1>
    </div>

    <form action="<?php echo e(isset($cuidado->id) ? route('dashboard.cuidados.update', $cuidado->id) : route('dashboard.cuidados.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($cuidado->id)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Datos del cuidado</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="producto_id">Producto</label>
                    <select name="producto_id" id="producto_id" class="form-select w-full" required>
                        <option value="">Seleccione...</option>
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($producto->id); ?>" <?php echo e(old('producto_id', $cuidado->producto_id ?? '') == $producto->id ? 'selected' : ''); ?>>
                                <?php echo e($producto->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label for="frecuencia_riego">Frecuencia de Riego</label>
                    <input type="text" name="frecuencia_riego" id="frecuencia_riego" class="form-input w-full"
                           value="<?php echo e(old('frecuencia_riego', $cuidado->frecuencia_riego ?? '')); ?>" required>
                </div>

                <div>
                    <label for="cantidad_agua">Cantidad de Agua</label>
                    <input type="text" name="cantidad_agua" id="cantidad_agua" class="form-input w-full"
                           value="<?php echo e(old('cantidad_agua', $cuidado->cantidad_agua ?? '')); ?>" required>
                </div>

                <div>
                    <label for="tipo_luz">Tipo de Luz</label>
                    <input type="text" name="tipo_luz" id="tipo_luz" class="form-input w-full"
                           value="<?php echo e(old('tipo_luz', $cuidado->tipo_luz ?? '')); ?>" required>
                </div>

                <div>
                    <label for="temperatura_ideal">Temperatura Ideal</label>
                    <input type="text" name="temperatura_ideal" id="temperatura_ideal" class="form-input w-full"
                           value="<?php echo e(old('temperatura_ideal', $cuidado->temperatura_ideal ?? '')); ?>">
                </div>

                <div>
                    <label for="tipo_sustrato">Tipo de Sustrato</label>
                    <input type="text" name="tipo_sustrato" id="tipo_sustrato" class="form-input w-full"
                           value="<?php echo e(old('tipo_sustrato', $cuidado->tipo_sustrato ?? '')); ?>">
                </div>

                <div>
                    <label for="frecuencia_abono">Frecuencia de Abono</label>
                    <input type="text" name="frecuencia_abono" id="frecuencia_abono" class="form-input w-full"
                           value="<?php echo e(old('frecuencia_abono', $cuidado->frecuencia_abono ?? '')); ?>">
                </div>

                <div>
                    <label for="plagas_comunes">Plagas Comunes</label>
                    <input type="text" name="plagas_comunes" id="plagas_comunes" class="form-input w-full"
                           value="<?php echo e(old('plagas_comunes', $cuidado->plagas_comunes ?? '')); ?>">
                </div>
            </div>

            <div>
                <label for="cuidados_adicionales">Cuidados Adicionales</label>
                <textarea name="cuidados_adicionales" id="cuidados_adicionales" class="form-textarea w-full" rows="3"><?php echo e(old('cuidados_adicionales', $cuidado->cuidados_adicionales ?? '')); ?></textarea>
            </div>

            <div>
                <label for="imagen_url">URL de Imagen</label>
                <input type="url" name="imagen_url" id="imagen_url" class="form-input w-full"
                       value="<?php echo e(old('imagen_url', $cuidado->imagen_url ?? '')); ?>">
                <?php if(!empty($cuidado->imagen_url)): ?>
                    <img src="<?php echo e($cuidado->imagen_url); ?>" alt="Imagen del cuidado" class="mt-3 w-32 h-32 object-cover rounded">
                <?php endif; ?>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route('dashboard.cuidados')); ?>" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700">
                <?php echo e(isset($cuidado->id) ? 'Actualizar' : 'Guardar'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/cuidados_edit.blade.php ENDPATH**/ ?>