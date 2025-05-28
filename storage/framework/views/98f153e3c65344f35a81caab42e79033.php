

<?php $__env->startSection('title', isset($cuidado->id) ? 'Editar cuidado' : 'Nuevo cuidado'); ?>

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

    <form action="<?php echo e(isset($cuidado->id) ? route('dashboard.cuidados.update', $cuidado->id) : route('dashboard.cuidados.store')); ?>"
          method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($cuidado->id)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Datos del cuidado</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label for="producto_id" class="block text-sm font-medium text-gray-700 mb-1">Producto <span class="text-red-500">*</span></label>
                    <select name="producto_id" id="producto_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Seleccione...</option>
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($producto->id); ?>" <?php echo e(old('producto_id', $cuidado->producto_id ?? '') == $producto->id ? 'selected' : ''); ?>>
                                <?php echo e($producto->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['producto_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="frecuencia_riego" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia de Riego <span class="text-red-500">*</span></label>
                    <input type="text" name="frecuencia_riego" id="frecuencia_riego" value="<?php echo e(old('frecuencia_riego', $cuidado->frecuencia_riego ?? '')); ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>

                
                <div>
                    <label for="cantidad_agua" class="block text-sm font-medium text-gray-700 mb-1">Cantidad de Agua <span class="text-red-500">*</span></label>
                    <input type="text" name="cantidad_agua" id="cantidad_agua" value="<?php echo e(old('cantidad_agua', $cuidado->cantidad_agua ?? '')); ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>

                
                <div>
                    <label for="tipo_luz" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Luz <span class="text-red-500">*</span></label>
                    <input type="text" name="tipo_luz" id="tipo_luz" value="<?php echo e(old('tipo_luz', $cuidado->tipo_luz ?? '')); ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                </div>

                
                <div>
                    <label for="temperatura_ideal" class="block text-sm font-medium text-gray-700 mb-1">Temperatura Ideal</label>
                    <input type="text" name="temperatura_ideal" id="temperatura_ideal" value="<?php echo e(old('temperatura_ideal', $cuidado->temperatura_ideal ?? '')); ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                
                <div>
                    <label for="tipo_sustrato" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Sustrato</label>
                    <input type="text" name="tipo_sustrato" id="tipo_sustrato" value="<?php echo e(old('tipo_sustrato', $cuidado->tipo_sustrato ?? '')); ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                
                <div>
                    <label for="frecuencia_abono" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia de Abono</label>
                    <input type="text" name="frecuencia_abono" id="frecuencia_abono" value="<?php echo e(old('frecuencia_abono', $cuidado->frecuencia_abono ?? '')); ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                
                <div>
                    <label for="plagas_comunes" class="block text-sm font-medium text-gray-700 mb-1">Plagas Comunes</label>
                    <input type="text" name="plagas_comunes" id="plagas_comunes" value="<?php echo e(old('plagas_comunes', $cuidado->plagas_comunes ?? '')); ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            
            <div class="mt-4">
                <label for="cuidados_adicionales" class="block text-sm font-medium text-gray-700 mb-1">Cuidados Adicionales</label>
                <textarea name="cuidados_adicionales" id="cuidados_adicionales" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"><?php echo e(old('cuidados_adicionales', $cuidado->cuidados_adicionales ?? '')); ?></textarea>
            </div>

            
            <div class="mt-4">
                <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Imagen del cuidado</label>
                <input type="file" name="imagen" id="imagen"
                    class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-green-50 file:text-green-700
                    hover:file:bg-green-100 transition">
                <?php if(!empty($cuidado->imagen_url)): ?>
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 mb-1">Imagen actual:</p>
                        <img src="<?php echo e($cuidado->imagen_url); ?>" alt="Imagen del cuidado" class="w-32 h-32 object-cover rounded">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route('dashboard.cuidados')); ?>"
               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
               Cancelar
            </a>
            <button type="submit"
                class="group relative px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -ml-1" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                <?php echo e(isset($cuidado->id) ? 'Actualizar' : 'Guardar'); ?> cuidado
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/cuidados_edit.blade.php ENDPATH**/ ?>