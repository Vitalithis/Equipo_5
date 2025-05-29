<?php $__env->startSection('title', 'Lista de Productos'); ?>

<?php $__env->startSection('content'); ?>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap"
        rel="stylesheet">

    <div class="max-w-7xl mx-auto font-['Roboto'] text-gray-800">
        <div class="rounded-lg shadow-sm p-6">

            <div class="mb-4 flex items-center justify-between">
                <form method="GET" action="<?php echo e(route('dashboard.catalogo')); ?>" class="flex space-x-4 items-center">
                    <input type="text" name="busqueda" value="<?php echo e(request('busqueda')); ?>" placeholder="Buscar por nombre"
                        class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-green-500" />

                    <select name="categoria" class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-green-500"">
                        <option value="">Todas las categorías</option>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('categoria') == $cat->nombre ? 'selected' : ''); ?>><?php echo e($cat->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                        Filtrar
                    </button>
                </form>

                <a href="<?php echo e(route('catalogo.create')); ?>"
                    class="ml-auto flex items-center text-green-700 hover:text-green-800 border border-green-700 hover:border-green-800 px-3 py-1 rounded transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    Añadir Producto
                </a>
            </div>

            <div class="overflow-x-auto rounded-xl border border-eaccent2">
                <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
                    <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                        <tr>
                            <th class="px-6 py-4 text-center">ID</th>
                            <th class="px-6 py-4 text-left">Imagen</th>
                            <th class="px-6 py-4 text-left">Nombre</th>
                            <th class="px-6 py-4 text-left">Precio</th>
                            <th class="px-6 py-4 text-left">Categoría</th>
                            <th class="px-6 py-4 text-left">Activo</th>
                            <th class="px-6 py-4 text-left">Stock</th>
                            <th class="px-6 py-4 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-eaccent2 font-['Roboto']">
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-4 py-2 text-center"><?php echo e($product->id); ?></td>
                                <td class="px-4 py-2">
                                    <img src="<?php echo e(asset($product->imagen)); ?>" alt="<?php echo e($product->nombre); ?>"
                                        class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="px-4 py-2"><?php echo e($product->nombre); ?></td>
                                <td class="px-4 py-2"><?php echo e($product->precio); ?></td>
                                <td class="px-4 py-2"><?php echo e($product->categoria); ?></td>
                                <td class="px-4 py-2"><?php echo e($product->activo ? 'Sí' : 'No'); ?></td>
                                <td class="px-4 py-2"><?php echo e($product->stock); ?></td>
                                <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-2 mt-2">
                                <a href="<?php echo e(route('catalogo_edit', ['id' => $product->id])); ?>"
                                class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                    Editar
                                </a>
                                <button type="button"
                                        class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors"
                                        onclick="openDeleteModal(<?php echo e($product->id); ?>, '<?php echo e($product->nombre); ?>', '<?php echo e($product->categoria); ?>')">
                                    Eliminar
                                </button>
                                </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="mt-6">
                    <?php echo e($productos->withQueryString()->links()); ?>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
            <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">¿Eliminar producto?</h2>
            <p class="text-gray-700 mb-4">
                ¿Estás seguro que deseas eliminar el producto <span id="modalProductName" class="font-semibold"></span>
                de la categoría <span id="modalProductCategory" class="font-semibold"></span>?
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
        function openDeleteModal(id, nombre, categoria) {
            document.getElementById('modalProductName').textContent = nombre;
            document.getElementById('modalProductCategory').textContent = categoria;
            document.getElementById('deleteForm').action = `/dashboard/catalogo/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Code\Equipo_5\resources\views/dashboard/catalog/catalogo.blade.php ENDPATH**/ ?>