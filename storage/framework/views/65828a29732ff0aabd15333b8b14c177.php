

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Gestión de Roles</h1>

    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="mb-4">
        <a href="<?php echo e(route('roles.create')); ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Nuevo Rol</a>
    </div>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nombre</th>
                <th class="py-2 px-4 border-b">Permisos</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="py-2 px-4 border-b"><?php echo e($role->name); ?></td>
                    <td class="py-2 px-4 border-b">
                        <?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded"><?php echo e($permission->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="<?php echo e(route('roles.edit', $role->id)); ?>" class="text-blue-500 hover:underline mr-2">Editar</a>
                        <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST" class="inline-block">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de eliminar este rol?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/roles/index.blade.php ENDPATH**/ ?>