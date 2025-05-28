

<?php $__env->startSection('title', isset($insumo->id) ? 'Editar insumo' : 'Nuevo insumo'); ?>

<?php $__env->startSection('content'); ?>
    <div class="py-8 px-4 md:px-8 max-w-4xl mx-auto" x-data="{ tipoUso: '<?php echo e(old('tipo_uso', $insumo->tipo_uso ?? '')); ?>' }">
        <div class="flex items-center mb-6">
            <a href="<?php echo e(route('dashboard.insumos')); ?>"
               class="flex items-center text-green-700 hover:text-green-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Volver a la lista
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
                <?php echo e(isset($insumo->id) ? 'Editar' : 'Nuevo'); ?> insumo
            </h1>
        </div>

        <form action="<?php echo e(isset($insumo->id) ? route('insumos.update', $insumo->id) : route('insumos.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php if(isset($insumo->id)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                    Información del insumo
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo e(old('nombre', $insumo->nombre ?? '')); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all"
                               required>
                        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label for="tipo_uso" class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo de uso <span class="text-red-500">*</span>
                        </label>
                        <select id="tipo_uso" name="tipo_uso" x-model="tipoUso"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all"
                                required>
                            <option value="">Seleccionar tipo</option>
                            <option value="venta" <?php echo e(old('tipo_uso', $insumo->tipo_uso ?? '') === 'venta' ? 'selected' : ''); ?>>Para venta</option>
                            <option value="uso" <?php echo e(old('tipo_uso', $insumo->tipo_uso ?? '') === 'uso' ? 'selected' : ''); ?>>Para uso interno</option>
                        </select>
                        <?php $__errorArgs = ['tipo_uso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                            Stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stock" name="stock" min="0"
                               value="<?php echo e(old('stock', $insumo->stock ?? 0)); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all"
                               required>
                        <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div x-show="tipoUso === 'venta'" x-transition>
                        <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">
                            Precio (solo si es para venta) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" id="precio" name="precio" min="0" step="1"
                                   :required="tipoUso === 'venta'"
                                   value="<?php echo e(old('precio', $insumo->precio ?? 0)); ?>"
                                   class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all">
                        </div>
                        <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="mt-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción
                    </label>
                    <textarea id="descripcion" name="descripcion" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all"><?php echo e(old('descripcion', $insumo->descripcion ?? '')); ?></textarea>
                    <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div class="flex justify-end space-x-4">
                <a href="<?php echo e(route('dashboard.insumos')); ?>"
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm text-gray-700 bg-white hover:bg-gray-50 focus:ring-green-500">
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
                    <?php echo e(isset($insumo->id) ? 'Actualizar' : 'Guardar'); ?> insumo
                </button>

            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/insumos_edit.blade.php ENDPATH**/ ?>