<!-- resources/views/partials/sidebar.blade.php -->
<div class="bg-blue-800 text-white w-64 flex-shrink-0" :class="{'-ml-64': !sidebarOpen}" class="lg:-ml-0">
  <div class="p-4 border-b border-blue-700">
    <div class="flex items-center space-x-2">
      <img src="{{ asset('dist/img/logoeditha.png') }}" alt="Logo" class="h-8 w-8 rounded-full">
      <span class="text-lg font-semibold">Planta de Producción</span>
    </div>
  </div>

  <div class="p-4 border-b border-blue-700">
    <div class="flex items-center space-x-3">
      <img src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User" class="h-10 w-10 rounded-full">
      <div>
        <div class="font-medium">{{ Auth::user()->name }}</div>
        <div class="text-blue-200 text-sm">Administrador</div>
      </div>
    </div>
  </div>

  <nav class="p-4">
    <ul>
      <li class="mb-1">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 px-3 py-2 bg-blue-700 rounded-md">
          <i class="fa-solid fa-gauge"></i>
          <span>Catalogo</span>
        </a>
      </li>
      <li class="mb-1">
        <a href="{{ route('ingresos') }}" class="flex items-center space-x-2 px-3 py-2 bg-blue-700 rounded-md">
          <i class="fa-regular fa-circle-user"></i>
          <span>Ingresos</span>
        </a>
      </li>
    </ul>
  </nav>
</div>
