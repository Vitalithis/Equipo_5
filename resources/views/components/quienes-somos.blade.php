<div class="flex flex-col md:flex-row w-full overflow-hidden h-fit">
  <!-- Sección Izquierda -->
  <div class="text-center md:w-1/2 flex flex-col justify-center items-center space-y-4 h-fit">
    <div class="bg-blue-100 my-22 py-22 w-full flex flex-col items-center">
      <h2 class="text-3xl font-semibold text-blue-900">¿Quiénes Somos?</h2>
      <p class="text-blue-800 text-2xl max-w-xl w-full font-bold">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus
        neque sed neque volutpat luctus. Cras gravida, mi in molestie volutpat,
        ex enim venenatis odio, vel ultricies nunc nisl nec elit.
      </p>
      <div class="flex gap-4 mt-4">
        <a href="#quienes" class="border border-blue-700 text-blue-700 px-4 py-2 rounded-md hover:bg-blue-200 transition">
          Conócenos más
        </a>
        <a href="/productos" class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition">
          Ver productos
        </a>
      </div>
    </div>
  </div>

  <!-- Sección Derecha (Imagen) -->
  <div class="md:w-1/2 flex justify-center items-center md:my-0 pr-4">
    <img
      src="{{ asset('images/quienes.jpg') }}"
      alt="Manos unidas sobre un tronco"
      class="w-full max-h-[500px] object-cover rounded-[50px]"
    />
  </div>
</div>
