

<?php $__env->startSection('title', isset($insumo) ? 'Editar Insumo' : 'Nuevo Insumo'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('dashboard.insumos')); ?>" class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver al listado
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            <?php echo e(isset($insumo) ? 'Editar' : 'Nuevo'); ?> Insumo
        </h1>
    </div>

    <form action="<?php echo e(isset($insumo) ? route('insumos.update', $insumo->id) : route('insumos.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($insumo)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-input w-full" required
                           value="<?php echo e(old('nombre', $insumo->nombre ?? '')); ?>">
                </div>

                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <input type="text" name="tipo" id="tipo" class="form-input w-full" required
                           value="<?php echo e(old('tipo', $insumo->tipo ?? '')); ?>">
                </div>

                <div>
                    <label for="unidad_medida" class="block text-sm font-medium text-gray-700">Unidad de Medida</label>
                    <input type="text" name="unidad_medida" id="unidad_medida" class="form-input w-full" required
                           value="<?php echo e(old('unidad_medida', $insumo->unidad_medida ?? '')); ?>">
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-input w-full" required
                           value="<?php echo e(old('stock', $insumo->stock ?? 0)); ?>">
                </div>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="form-textarea w-full"><?php echo e(old('descripcion', $insumo->descripcion ?? '')); ?></textarea>
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activo" value="1" class="form-checkbox text-green-600"
                        <?php echo e(old('activo', $insumo->activo ?? true) ? 'checked' : ''); ?>>
                    <span class="ml-2 text-gray-700">Activo</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route('dashboard.insumos')); ?>" class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                <?php echo e(isset($insumo) ? 'Actualizar' : 'Guardar'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/insumos_edit.blade.php ENDPATH**/ ?>