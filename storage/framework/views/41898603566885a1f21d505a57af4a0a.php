<div class="flex flex-col md:flex-row w-full overflow-hidden h-fit">
  <!-- Sección Izquierda -->
  <div class="text-center md:w-1/2 flex items-center justify-center h-full bg-white py-8 md:py-20">
    <div class="bg-blue-100 px-4 py-16 my-20 w-full flex flex-col items-center">
      <h2 class="text-3xl font-semibold text-blue-900">¿Quiénes Somos?</h2>
      <p class="text-blue-800 text-2xl mt-4">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus
        neque sed neque volutpat luctus. Cras gravida, mi in molestie volutpat,
        ex enim venenatis odio, vel ultricies nunc nisl nec elit.
      </p>
      <div class="flex gap-4 mt-6">
        <button class="border border-blue-700 text-blue-700 px-4 py-2 rounded-md hover:bg-blue-200 transition">
          Conócenos más
        </button>
        <button class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition">
          Ver productos
        </button>
      </div>
    </div>
  </div>

  <!-- Sección Derecha (Imagen) -->
  <div class="md:w-1/2 flex items-center justify-center md:my-0 pr-4">
    <img
      src=<?php echo e(asset('/storage/images/quienes.jpg')); ?>

      alt="Manos unidas sobre un tronco"
      class="w-full max-h-[500px] object-cover rounded-[50px]"
    />
  </div>
</div>
<?php /**PATH D:\Code\Equipo_5\resources\views/components/quienes-somos.blade.php ENDPATH**/ ?>