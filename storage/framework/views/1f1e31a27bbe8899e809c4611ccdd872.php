

<?php $__env->startSection('title', $proveedor->id ? 'Editar proveedor' : 'Nuevo proveedor'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('proveedores.index')); ?>"
           class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            <?php echo e($proveedor->id ? 'Editar' : 'Nuevo'); ?> proveedor
        </h1>
    </div>

    <form method="POST" action="<?php echo e($proveedor->id ? route('proveedores.update', $proveedor) : route('proveedores.store')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php if($proveedor->id): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6 space-y-4">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="<?php echo e(old('nombre', $proveedor->nombre)); ?>"
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Empresa</label>
                    <input type="text" name="empresa" value="<?php echo e(old('empresa', $proveedor->empresa)); ?>"
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $proveedor->email)); ?>"
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="text" name="telefono" value="<?php echo e(old('telefono', $proveedor->telefono)); ?>"
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Proveedor</label>
                    <select name="tipo_proveedor" class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Seleccionar</option>
                        <?php $__currentLoopData = ['Insumos médicos', 'Farmacia', 'Servicios externos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo); ?>" <?php echo e(old('tipo_proveedor', $proveedor->tipo_proveedor) == $tipo ? 'selected' : ''); ?>>
                                <?php echo e($tipo); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="estado" class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        <?php $__currentLoopData = ['Activo', 'Inactivo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($estado); ?>" <?php echo e(old('estado', $proveedor->estado) == $estado ? 'selected' : ''); ?>>
                                <?php echo e($estado); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Dirección</label>
                <textarea name="direccion" rows="2"
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"><?php echo e(old('direccion', $proveedor->direccion)); ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Notas</label>
                <textarea name="notas" rows="3"
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"><?php echo e(old('notas', $proveedor->notas)); ?></textarea>
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-4">
            <a href="<?php echo e(route('proveedores.index')); ?>"
               class="px-4 py-2 border rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                <?php echo e($proveedor->id ? 'Actualizar' : 'Guardar'); ?>

            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/proveedores/form.blade.php ENDPATH**/ ?>