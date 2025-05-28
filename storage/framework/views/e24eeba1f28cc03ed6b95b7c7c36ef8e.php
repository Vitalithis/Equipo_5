<?php $__env->startSection('title', isset($finanza->id) ? 'Editar Movimiento Financiero' : 'Nuevo Movimiento Financiero'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('dashboard.finanzas')); ?>" class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver al listado
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            <?php echo e(isset($finanza->id) ? 'Editar' : 'Nuevo'); ?> Movimiento Financiero
        </h1>
    </div>

    <form action="<?php echo e(isset($finanza->id) ? route('finanzas.update', $finanza->id) : route('finanzas.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($finanza->id)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <h2 class="text-xl font-medium text-gray-800 mb-2 pb-2 border-b border-gray-200">Datos del movimiento</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select w-full" required>
                        <option value="ingreso" <?php echo e(old('tipo', $finanza->tipo ?? '') == 'ingreso' ? 'selected' : ''); ?>>Ingreso</option>
                        <option value="egreso" <?php echo e(old('tipo', $finanza->tipo ?? '') == 'egreso' ? 'selected' : ''); ?>>Egreso</option>
                    </select>
                </div>

                <div>
                    <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
                    <input type="number" step="0.01" name="monto" id="monto" class="form-input w-full"
                           value="<?php echo e(old('monto', $finanza->monto ?? '')); ?>" required>
                </div>

                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-input w-full"
                           value="<?php echo e(old('fecha', isset($finanza->fecha) ? $finanza->fecha : now()->toDateString())); ?>" required>
                </div>

                
                <?php
                    $categoriasPredeterminadas = config('finanzas.categorias');
                    $categoriaActual = old('categoria', $finanza->categoria ?? '');
                ?>

                <div x-data="{ categoria: '<?php echo e($categoriaActual); ?>' }">
                    <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select x-model="categoria" class="form-select w-full">
                        <option value="">Selecciona una categoría</option>
                        <?php $__currentLoopData = $categoriasPredeterminadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat); ?>" <?php echo e($categoriaActual === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <option value="otro" :selected="!<?php echo e(Js::from($categoriasPredeterminadas)); ?>.includes(categoria)">Otra...</option>
                    </select>

                    <template x-if="categoria === 'otro'">
                        <input type="text" name="categoria" class="form-input mt-2 w-full"
                               placeholder="Especifica la categoría" value="<?php echo e($categoriaActual); ?>">
                    </template>

                    <template x-if="categoria !== 'otro'">
                        <input type="hidden" name="categoria" :value="categoria">
                    </template>
                </div>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4" class="form-textarea w-full"><?php echo e(old('descripcion', $finanza->descripcion ?? '')); ?></textarea>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route('dashboard.finanzas')); ?>" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700">
                <?php echo e(isset($finanza->id) ? 'Actualizar' : 'Guardar'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\Equipo_5\resources\views/dashboard/finanzas_edit.blade.php ENDPATH**/ ?>