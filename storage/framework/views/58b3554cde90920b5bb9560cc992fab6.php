<?php $__env->startSection('title', 'Lista de Proveedores'); ?>

<?php $__env->startSection('content'); ?>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <div class="max-w-7xl mx-auto font-['Roboto'] text-gray-800">
        <?php if(session('success')): ?>
    <div id="success-message" class="bg-[#FFF9DB] border-l-4 border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

        <div class="rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold font-['Roboto_Condensed'] text-gray-800">Proveedores</h2>
                <a href="<?php echo e(route('proveedores.create')); ?>"
                   class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir Proveedor
                </a>
            </div>

            <div class="overflow-x-auto rounded-xl border border-eaccent2">
                <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
                    <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                        <tr>
                            <th class="px-6 py-4 text-center">ID</th>
                            <th class="px-6 py-4 text-left">Nombre</th>
                            <th class="px-6 py-4 text-left">Empresa</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Teléfono</th>
                            <th class="px-6 py-4 text-left">Tipo</th>
                            <th class="px-6 py-4 text-left">Estado</th>
                            <th class="px-6 py-4 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-eaccent2 font-['Roboto']">
                        <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proveedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-4 py-2 text-center"><?php echo e($proveedor->id); ?></td>
                                <td class="px-4 py-2"><?php echo e($proveedor->nombre); ?></td>
                                <td class="px-4 py-2"><?php echo e($proveedor->empresa); ?></td>
                                <td class="px-4 py-2"><?php echo e($proveedor->email); ?></td>
                                <td class="px-4 py-2"><?php echo e($proveedor->telefono); ?></td>
                                <td class="px-4 py-2"><?php echo e($proveedor->tipo_proveedor); ?></td>
                                <td class="px-4 py-2"><?php echo e($proveedor->estado); ?></td>
                                <td class="px-4 py-2">
                                <div class="flex space-x-3">
                                    <a href="<?php echo e(route('proveedores.edit', $proveedor)); ?>" class="text-blue-600 hover:underline">Editar</a>
                                    <button type="button" class="text-red-600 hover:underline"
                                        onclick="openDeleteModal(<?php echo e($proveedor->id); ?>, '<?php echo e($proveedor->nombre); ?>', '<?php echo e($proveedor->empresa); ?>')">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
            <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">¿Eliminar proveedor?</h2>
            <p class="text-gray-700 mb-4">
                ¿Estás seguro que deseas eliminar al proveedor <span id="modalProviderName" class="font-semibold"></span>
                de la empresa <span id="modalProviderCompany" class="font-semibold"></span>?
            </p>
            <form id="deleteForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(id, nombre, empresa) {
            document.getElementById('modalProviderName').textContent = nombre;
            document.getElementById('modalProviderCompany').textContent = empresa;
            document.getElementById('deleteForm').action = `/proveedores/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Code\Equipo_5\resources\views/proveedores/index.blade.php ENDPATH**/ ?>