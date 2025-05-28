<?php
    $proveedor = $proveedor ?? new \App\Models\Proveedor();
?>

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
                <?php $__currentLoopData = ['Tierra', 'Insumos (Fertilizante/Fungicida)', 'Plantas', 'Plantines', 'Plasticos/ceramicas', 'Sustratos', 'Servicios Vivero', 'Construccion']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/proveedores/form-fields.blade.php ENDPATH**/ ?>