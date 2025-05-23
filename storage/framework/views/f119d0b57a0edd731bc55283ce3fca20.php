<?php $__env->startSection('title', 'Editar Rol'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto py-8" style="font-family: 'Roboto', sans-serif;">

    
    <a href="<?php echo e(route('roles.index')); ?>"
       class="mb-4 inline-flex items-center text-green-700 hover:text-green-800 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6" />
        </svg>
        Volver a la lista
    </a>

    <form action="<?php echo e(route('roles.update', $role->id)); ?>" method="POST" class="bg-white shadow rounded-lg p-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Rol</label>
            <input type="text" name="name" id="name" value="<?php echo e($role->name); ?>" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-eaccent focus:border-eaccent">
        </div>

        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Permisos</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>"
                               <?php if($role->permissions->contains($permission)): ?> checked <?php endif; ?>
                               class="form-checkbox text-eaccent border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700"><?php echo e($permission->name); ?></span>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="mt-6">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                Actualizar
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/dashboard/roles/edit.blade.php ENDPATH**/ ?>