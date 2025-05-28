<?php $__env->startSection('title', 'Plantas Editha'); ?>
<?php $__env->startSection('description', 'Bienvenido a Plantas Editha, tu destino para plantas de interior y exterior. Descubre nuestra misión, visión y más.'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.hero', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.quienes-somos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.mision-vision', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.faq', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.contact', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\TRABAJO\Equipo_5\resources\views/home.blade.php ENDPATH**/ ?>