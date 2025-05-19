<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $__env->yieldContent('title', 'Plantas Editha'); ?></title>

    <!-- Aquí puedes cargar tus estilos generales -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    <!-- Sección para agregar estilos personalizados -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-white dark:bg-gray-900 flex flex-col min-h-screen">

    
    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <main class="flex-grow">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Scripts generales -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

    <!-- Sección para agregar scripts personalizados -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Code\Equipo_5\resources\views/layouts/home.blade.php ENDPATH**/ ?>