<?php $__env->startSection('title', $producto->nombre); ?>
<?php $__env->startSection('content'); ?>

<div class="w-full md:w-3/4 lg:w-4/5 mx-auto bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Imagen principal -->
        <img src="<?php echo e(asset('storage/images/product' . $producto->imagen_principal)); ?>"
            onerror="this.onerror=null;this.src='storage/images/default-logo.png';"
            alt="<?php echo e($producto->nombre); ?>"
            class="w-full md:w-1/2 h-auto object-cover rounded-lg">

        <!-- Detalles del producto -->
        <div class="flex-1 space-y-4 text-blueDark">
            <h2 class="text-3xl font-bold"><?php echo e($producto->nombre); ?></h2>
            <p class="text-greenPrimary text-2xl font-semibold"><?php echo e(number_format($producto->precio, 0, ',', '.')); ?> CLP</p>

            <div>
                <p><strong>Tamaño:</strong> <?php echo e($producto->tamano); ?> cm</p>
                <p><strong>Dificultad:</strong> <?php echo e($producto->nivel_dificultad); ?></p>
                <p><strong>Categoría:</strong> <?php echo e($producto->categoria); ?></p>
                <p class="mt-4"><?php echo e($producto->descripcion_larga ?? $producto->descripcion_corta); ?></p>
            </div>

            <!-- Agregar al carrito -->
            <form method="POST" action="<?php echo e(route('cart.add', ['id' => $producto->id])); ?>" class="space-y-4">

                <?php echo csrf_field(); ?>
                <input type="hidden" name="producto_id" value="<?php echo e($producto->id); ?>">

                <label for="cantidad" class="block text-sm font-medium">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" value="1" min="1"
                    class="w-24 px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">

                <button type="submit"
                    class="block w-full md:w-auto bg-greenPrimary text-white px-6 py-2 rounded-lg hover:bg-greenDark transition-colors">
                    🛒 Agregar al carrito
                </button>
            </form>

            <!-- Volver -->
            <a href="<?php echo e(route('products.index')); ?>"
                class="inline-block mt-4 text-sm text-blueDark hover:text-blue-600 transition">
                ← Volver a productos
            </a>
        </div>
    </div>

    <!-- Productos relacionados -->
    <?php if($relacionados->count()): ?>
        <h3 class="text-xl font-semibold text-blueDark mt-10 mb-4">Productos relacionados</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $relacionados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <a href="<?php echo e(route('products.show', $rel->slug)); ?>">
                        <img src="<?php echo e(asset('storage/images/product' . $rel->imagen_principal)); ?>"
                             onerror="this.onerror=null;this.src='storage/images/default-logo.png';"
                             class="w-full h-32 object-cover rounded mb-2">
                        <h4 class="text-blueDark font-semibold"><?php echo e($rel->nombre); ?></h4>
                        <p class="text-greenPrimary font-bold"><?php echo e(number_format($rel->precio, 0, ',', '.')); ?> CLP</p>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Code\Equipo_5\resources\views/products/show.blade.php ENDPATH**/ ?>