<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Bienvenido al Dashboard</h2>
        <p class="text-gray-600">Usa el menú lateral para acceder a las secciones del sistema.</p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/dashboard.blade.php ENDPATH**/ ?>