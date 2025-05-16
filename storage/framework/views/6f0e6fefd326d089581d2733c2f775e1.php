<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4"><?php echo e($role ? 'Editar Rol' : 'Crear Nuevo Rol'); ?></h1>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>- <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e($role ? route('roles.update', $role->id) : route('roles.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if($role): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nombre del Rol:</label>
            <input type="text" name="name" id="name" value="<?php echo e(old('name', $role->name ?? '')); ?>" class="w-full border border-gray-300 px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Permisos:</label>
            <div class="grid grid-cols-2 gap-2">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>"
                                <?php echo e((isset($role) && $role->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : ''); ?>

                                class="form-checkbox">
                            <span class="ml-2"><?php echo e($permission->name); ?></span>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                <?php echo e($role ? 'Actualizar Rol' : 'Crear Rol'); ?>

            </button>
            <a href="<?php echo e(route('roles.index')); ?>" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/dashboard/roles/form.blade.php ENDPATH**/ ?>