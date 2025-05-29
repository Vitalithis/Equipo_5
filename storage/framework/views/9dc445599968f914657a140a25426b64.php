<?php $__env->startSection('title', 'Reportes de Mantención'); ?>

<?php $__env->startSection('content'); ?>
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="max-w-7xl mx-auto font-['Roboto'] text-gray-800">
    <div class="rounded-lg shadow-sm p-6">
        <div class="mb-4 flex justify-between items-center">

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar infraestructura')): ?>
                <a href="<?php echo e(route('maintenance.create')); ?>"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Nuevo Reporte
                </a>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto rounded-xl border">
            <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
                <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-4 py-3">Título</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Costo</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y font-['Roboto']">
                    <?php $__currentLoopData = $maintenances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo e($item->title); ?></td>
                            <td class="px-4 py-2"><?php echo e(ucfirst($item->status)); ?></td>
                            <td class="px-4 py-2"><?php echo e($item->updated_at->format('d-m-Y H:i')); ?></td>
                            <td class="px-4 py-2">$<?php echo e(number_format($item->cost, 0, ',', '.')); ?></td>
                            <td class="px-4 py-2">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar infraestructura')): ?>
                                    <a href="<?php echo e(route('maintenance.edit', $item->id)); ?>"
                                        class="text-blue-600 hover:underline text-sm">Editar</a>
                                    <button type="button" onclick="openDeleteModal(<?php echo e($item->id); ?>, '<?php echo e($item->title); ?>')"
                                        class="text-red-600 hover:underline text-sm ml-2">Eliminar</button>
                                <?php else: ?>
                                    <span class="text-gray-500 italic text-sm">Solo lectura</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="mt-4"><?php echo e($maintenances->links()); ?></div>
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
        <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">¿Eliminar reporte?</h2>
        <p class="text-gray-700 mb-4">¿Deseas eliminar el reporte <span id="modalTitle" class="font-semibold"></span>?</p>
        <form id="deleteForm" method="POST" action="">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(id, title) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('deleteForm').action = `/maintenance/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Code\Equipo_5\resources\views/maintenances/index.blade.php ENDPATH**/ ?>