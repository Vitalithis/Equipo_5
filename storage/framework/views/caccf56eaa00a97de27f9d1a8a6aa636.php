<?php $__env->startSection('title', 'Gestión de Usuarios'); ?>

<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800">
    <div class="flex items-center justify-between mb-6">
        
    </div>

    <div class="w-full overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
        <table class="min-w-full table-auto divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-4 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-4 py-3 whitespace-nowrap">Email</th>
                    <th class="px-4 py-3 whitespace-nowrap">Rol actual</th>
                    <th class="px-4 py-3 whitespace-nowrap">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-4 py-3 font-medium whitespace-nowrap"><?php echo e($user->name); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap"><?php echo e($user->email); ?></td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <?php echo e($user->roles->pluck('name')->join(', ') ?: 'user'); ?>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <?php if($user->email === 'admin@editha.com'): ?>
                                <span class="text-gray-400 italic">Protegido</span>
                            <?php else: ?>
                                <form action="<?php echo e(route('users.updateRole', $user)); ?>" method="POST" class="flex items-center space-x-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <select name="role" class="border rounded px-2 py-1 text-sm">
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->name); ?>" <?php echo e($user->hasRole($role->name) ? 'selected' : ''); ?>>
                                                <?php echo e($role->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                                        Asignar
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/dashboard/users/index.blade.php ENDPATH**/ ?>