<div class="w-full h-screen px-10">
  <div class="relative w-full bg-white rounded-4xl h-4/5 overflow-hidden">

    <!-- Fondo con imagen e información centrada -->
    <div class="absolute inset-0 w-full h-full bg-white rounded-4xl overflow-hidden">
      <div class="absolute inset-0 flex items-center justify-center z-10 flex-col">
        <h1 class="text-4xl font-bold text-center text-white font-['Roboto_Condensed']">
          Tu espacio verde comienza aquí.
        </h1>
        <button class="mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300">
          ¡Comienza ahora!
        </button>
      </div>

      <!-- Imagen de fondo -->
      <img
        src="<?php echo e(asset('images/slide1.jpg')); ?>"
        alt="Imagen de fondo"
        class="absolute inset-0 w-full h-full object-cover rounded-3xl brightness-50"
      />
    </div>

    <!-- Notch inferior centrado -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-42 h-10 bg-white rounded-t-xl">
      <div class="absolute inset-0 flex items-center justify-center">
        <img
          src="<?php echo e(asset('images/arrowdown.svg')); ?>"
          alt="Flecha hacia abajo"
          class="w-8 h-8 animate-[float_3s_ease-in-out_infinite]"
        />
      </div>
    </div>

  </div>
</div>

<style>
  @keyframes float {
    0%, 100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-3px);
    }
  }
</style>
<?php /**PATH D:\Code\Equipo_5\resources\views/components/hero.blade.php ENDPATH**/ ?>