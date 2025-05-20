<?php $__env->startSection('title', 'Lista de Productos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto bg-efore" style="background-color:rgb(248,246,244) !important"><div class="bg-white rounded-lg shadow-sm p-6 ">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Productos</h2>
                <a href="<?php echo e(route('catalogo.create')); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-md">Añadir
                    Producto</a>
            </div>
            <div class="overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
                <table class="min-w-full bg-white border-0 ">
                    <thead class="bg-eaccent2 text-eprimary uppercase tracking-wide text-xs">
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
                    <tbody>
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-4 py-2 text-center"><?php echo e($product->id); ?></td>
                                <td class="px-4 py-2">
                                    <img src="<?php echo e(asset('storage/' . $product->imagen)); ?>" alt="<?php echo e($product->nombre); ?>"
                                        class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="px-4 py-2"><?php echo e($product->nombre); ?></td>
                                <td class="px-4 py-2"><?php echo e($product->precio); ?></td>
                                <td class="px-4 py-2"><?php echo e($product->categoria); ?></td>
                                <td class="px-4 py-2">
                                    <?php if($product->activo): ?>
                                        Sí
                                    <?php else: ?>
                                        No
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2"><?php echo e($product->stock); ?></td>
                                <td class="px-4 py-2">
                                    <a href="<?php echo e(route('catalogo_edit', ['id' => $product->id])); ?>"
                                        class="text-blue-500">Editar</a>
                                    <button type="button" class="text-red-500 ml-2"
                                        onclick="openDeleteModal(<?php echo e($product->id); ?>, '<?php echo e($product->nombre); ?>', '<?php echo e($product->categoria); ?>')">
                                        Eliminar
                                    </button>
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
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-bold text-gray-800 mb-4">¿Eliminar producto?</h2>
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/catalogo.blade.php ENDPATH**/ ?>