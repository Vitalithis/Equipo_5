<?php $__env->startSection('title', $role ? 'Editar Rol' : 'Crear Rol'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
        <?php echo e($role ? 'Editar Rol' : 'Crear Nuevo Rol'); ?>

    </h1>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
            <ul class="list-disc list-inside">
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
            <label for="name" class="block text-gray-700 font-medium">Nombre del Rol:</label>
            <input type="text" name="name" id="name" value="<?php echo e(old('name', $role->name ?? '')); ?>"
                   class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Permisos:</label>
            <div class="grid grid-cols-2 gap-2">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>"
                                <?php echo e((isset($role) && $role->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : ''); ?>

                                class="form-checkbox text-indigo-600">
                            <span class="ml-2"><?php echo e($permission->name); ?></span>
                        </label>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="flex justify-start">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                <?php echo e($role ? 'Actualizar Rol' : 'Crear Rol'); ?>

            </button>
            <a href="<?php echo e(route('roles.index')); ?>" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/dashboard/roles/form.blade.php ENDPATH**/ ?>