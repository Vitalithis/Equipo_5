<?php
    $niveles = [
        'fácil' => ['color' => 'text-green-500', 'cantidad' => 1],
        'intermedio' => ['color' => 'text-yellow-500', 'cantidad' => 2],
        'experto' => ['color' => 'text-red-500', 'cantidad' => 3],
    ];

    $nivel = $niveles[strtolower($producto->nivel_dificultad)] ?? ['color' => 'text-gray-400', 'cantidad' => 0];
?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row w-full items-start bg-white p-8 rounded-lg shadow-lg">

    
    <img src="<?php echo e(asset('storage/' . (file_exists(public_path('storage/' . $producto->imagen)) ? $producto->imagen : 'images/default-logo.png'))); ?>"
        class="w-full md:w-2/5 max-h-80 object-contain rounded-lg mb-4 md:mb-0  self-center">

    
    <div class="md:ml-8 w-full md:w-3/5">

        
        <h1 class="font-bold text-4xl text-eprimary"><?php echo e($producto->nombre); ?></h1>

        <?php if($producto->nombre_cientifico): ?>
            <p class="text-sm text-gray-600 mt-2"><strong>Nombre científico:</strong> <?php echo e($producto->nombre_cientifico); ?></p>
        <?php endif; ?>

        <?php if($producto->descripcion): ?>
            <p class="text-md text-gray-700 mt-4"><?php echo e($producto->descripcion); ?></p>
        <?php endif; ?>

        <p class="text-gray-600 mt-2 text-sm">Planta <?php echo e($producto->categoria); ?>

            <?php if($producto->ubicacion_ideal): ?>
                de <?php echo e($producto->ubicacion_ideal); ?>

            <?php endif; ?>
        </p>

        <?php if($producto->nivel_dificultad): ?>
            <div class="mt-4 flex items-center space-x-2">
                <span class="text-sm font-semibold text-gray-700">Dificultad:</span>
                <div class="flex items-center space-x-1">
                    <?php for($i = 0; $i < $nivel['cantidad']; $i++): ?>
                        <span class="<?php echo e($nivel['color']); ?> w-5 h-5">
                            <?php echo str_replace('<svg', '<svg class="fill-eaccent2 w-5 h-5"', file_get_contents(public_path('icons/leaf-fill.svg'))); ?>

                        </span>
                    <?php endfor; ?>
                </div>
                <span class="text-sm text-gray-600 capitalize">(<?php echo e($producto->nivel_dificultad); ?>)</span>
            </div>
        <?php endif; ?>

        <?php if($producto->frecuencia_riego): ?>
            <p class="text-sm text-esecondary mt-4 flex items-center space-x-2">
                <?php echo str_replace('<svg', '<svg class="fill-esecondary w-5 h-5"', file_get_contents(public_path('icons/drop-fill.svg'))); ?>

                <span><?php echo e($producto->frecuencia_riego); ?></span>
            </p>
        <?php endif; ?>

        <p class="text-gray-600 mt-4 text-lg font-semibold">$<?php echo e(number_format($producto->precio, 3)); ?></p>

        
        <form action="<?php echo e(route('cart.add', $producto->id)); ?>" method="POST" class="mt-2">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="cantidad" value="1">
    <button class="add-to-cart mt-4 bg-eaccent hover:bg-eaccent2 text-white px-6 py-3 rounded-lg font-bold transition duration-300 ease-in-out transform hover:scale-105">
        Agregar al carrito
    </button>
</form>



        <p class="text-gray-600 mt-4"><strong>Cantidad disponible:</strong> <?php echo e($producto->cantidad); ?></p>

        
        <div class="mt-6 border-t pt-6">

            <?php if($producto->descripcion): ?>
                <div>
                    <h2 class="text-xl font-semibold text-eprimary mb-2">Descripción detallada</h2>
                    <p class="text-gray-700"><?php echo e($producto->descripcion); ?></p>
                </div>
            <?php endif; ?>

            <?php if($producto->beneficios): ?>
                <div class="mt-6">
                    <h3 class="text-md font-semibold text-eprimary">Beneficios</h3>
                    <p class="text-gray-700"><?php echo e($producto->beneficios); ?></p>
                </div>
            <?php endif; ?>

            <div class="mt-6 space-y-1">
                <p class="text-sm text-eprimary"><strong>Tóxica para mascotas:</strong> <?php echo e($producto->toxica ? 'Sí' : 'No'); ?></p>
                <?php if($producto->origen): ?>
                    <p class="text-sm text-eprimary"><strong>Origen:</strong> <?php echo e($producto->origen); ?></p>
                <?php endif; ?>
                <?php if($producto->tamano): ?>
                    <p class="text-sm text-eprimary"><strong>Tamaño:</strong> <?php echo e($producto->tamano); ?> cm</p>
                <?php endif; ?>
                <!-----<p class="text-sm text-eprimary"><strong>Código de barras:</strong> <?php echo e($producto->codigo_barras); ?></p>--->
            </div>

        </div>

    </div>
</div>

<?php if(isset($relacionados) && count($relacionados)): ?>
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-eprimary mb-6">Productos relacionados</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $relacionados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
                    <img src="<?php echo e(asset('storage/' . (file_exists(public_path('storage/' . $rel->imagen)) ? $rel->imagen : 'images/default-logo.png'))); ?>"
                        alt="<?php echo e($rel->nombre); ?>"
                        class="w-full h-48 object-contain rounded-md mb-4">

                    <h3 class="text-lg font-semibold text-eprimary"><?php echo e($rel->nombre); ?></h3>

                    <?php if($rel->precio): ?>
                        <p class="text-sm text-gray-700 mt-1">$<?php echo e(number_format($rel->precio, 3)); ?></p>
                    <?php endif; ?>

                    <a href="<?php echo e(route('products.show', $rel->id)); ?>"
                        class="mt-auto inline-block bg-eaccent hover:bg-eaccent2 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Ver producto
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/products/index.blade.php ENDPATH**/ ?>