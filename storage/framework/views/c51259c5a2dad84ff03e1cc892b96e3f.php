<?php $__env->startSection('title', 'Crear Rol'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8 font-['Roboto'] text-gray-800">

    <a href="<?php echo e(route('roles.index')); ?>"
       class="mb-4 inline-flex items-center text-green-700 hover:text-green-800 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6" />
        </svg>
        Volver a la lista
    </a>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('roles.store')); ?>" method="POST" class="bg-white shadow rounded-lg p-6">
        <?php echo csrf_field(); ?>

        
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Rol</label>
            <input type="text" name="name" id="name" required
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-eaccent focus:border-eaccent px-4 py-2">
        </div>

        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Permisos</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-0 border border-eaccent2 rounded overflow-hidden">

                <?php
                    $grouped = [
                        'Dashboard' => ['ver dashboard'],
                        'Usuarios' => ['gestionar usuarios', 'ver usuarios'],
                        'Permisos' => ['gestionar permisos'],
                        'Roles' => ['ver roles', 'crear roles', 'editar roles', 'eliminar roles'],
                        'Órdenes' => ['ver ordenes', 'crear ordenes', 'editar ordenes', 'eliminar ordenes'],
                        'Ingresos' => ['gestionar ingresos'],
                        'Egresos' => ['gestionar egresos'],
                        'Productos' => ['gestionar productos'],
                        'Catálogo' => ['gestionar catálogo'],
                        'Descuentos' => ['gestionar descuentos'],
                        'Reportes' => ['ver reportes'],
                        'Pedidos' => ['gestionar pedidos']
                    ];
                ?>

                <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-t border-eaccent2 border-r p-4">
                        <h3 class="font-bold text-eprimary mb-2"><?php echo e($group); ?></h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2">
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(in_array($permission->name, $perms)): ?>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>"
                                            class="form-checkbox text-eaccent border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700"><?php echo e($permission->name); ?></span>
                                    </label>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded shadow">
                Guardar
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/dashboard/roles/create.blade.php ENDPATH**/ ?>