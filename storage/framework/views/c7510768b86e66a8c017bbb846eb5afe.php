<?php $__env->startSection('title', 'Listado de Roles'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-7xl mx-auto">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            Roles del Sistema
        </h1>
        <a href="<?php echo e(route('roles.create', ['source' => $source])); ?>"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Rol
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg">
        <table class="min-w-full table-auto divide-y divide-gray-200 text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="w-1/6 px-4 py-3">Nombre</th>
                    <th class="w-3/5 px-4 py-3">Permisos</th>
                    <th class="w-1/6 px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        
                        <td class="px-4 py-3 font-medium text-gray-800 border-r border-gray-200">
                            <?php echo e($role->name); ?>

                        </td>

                        
                        <td class="px-4 py-3 text-gray-700 border-r border-gray-200">
                            <?php if($role->permissions->isEmpty()): ?>
                                <span class="italic text-gray-400">Sin permisos asignados</span>
                            <?php else: ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1">
                                    <?php $__currentLoopData = $role->permissions->pluck('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="text-sm"><?php echo e($perm); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </td>

                        
                        <td class="px-4 py-3 text-gray-700">
                            <?php if($role->name !== 'superadmin'): ?>
                                <a href="<?php echo e(route('roles.edit', ['role' => $role->id, 'source' => $source])); ?>"
                                   class="text-blue-600 hover:underline">Editar</a>
                                <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST" class="inline-block ml-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            onclick="return confirm('¿Estás seguro de eliminar este rol?')"
                                            class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Protegido</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/dashboard/roles/index.blade.php ENDPATH**/ ?>