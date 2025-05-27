<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Plantas Editha | Dashboard')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans" x-data="dashboard">
  <div class="flex h-screen">

    @php
        $color = 'green'; 
        $seccion = 'Panel de Administración';
    @endphp

    <div class="bg-{{ $color }}-800 text-white w-64 flex-shrink-0" :class="{'-ml-64': !sidebarOpen}">
      <div class="p-4 border-b border-{{ $color }}-700">
        <div class="flex items-center space-x-2">
          <img src="{{ asset('dist/img/logoeditha.png') }}" alt="Logo" class="h-20 w-20 rounded-full">
          <span class="text-lg font-semibold">{{ $seccion }}</span>
        </div>
      </div>

      <div class="p-4 border-b border-{{ $color }}-700">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User" class="h-10 w-10 rounded-full">
          <div>
            <div class="font-medium">{{ Auth::user()->name }}</div>
            @php $rol = Auth::user()->getRoleNames()->first(); @endphp
            <div class="text-sm text-white bg-{{ $color }}-600 rounded-full px-2 py-0.5 inline-block mt-1">
              {{ $rol ?? 'Sin rol' }}
            </div>
          </div>
        </div>
      </div>

      <nav class="p-4">
        <ul>
          @can('ver dashboard')
          <li class="mb-1">
            <a href="{{ route('home') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
              <i class="fa-solid fa-house"></i>
              <span>Home</span>
            </a>
          </li>
          @endcan

          @can('gestionar catálogo')
          <li class="mb-1">
            <a href="{{ route('dashboard.catalogo') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
              <i class="fa-solid fa-seedling"></i>
              <span>Catálogo</span>
            </a>
          </li>
          @endcan

          @can('ver roles')
          <li class="mb-1">
            <a href="{{ route('roles.index') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
              <i class="fa-solid fa-user-shield"></i>
              <span>Roles</span>
            </a>
          </li>
          @endcan

          @can('gestionar usuarios')
          <li class="mb-1">
            <a href="{{ route('users.index') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
              <i class="fa-solid fa-users"></i>
              <span>Usuarios</span>
            </a>
          </li>
          @endcan

          @can('gestionar pedidos')
          <li class="mb-1">
            <a href="{{ route('pedidos.index') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
              <i class="fa-solid fa-box-open"></i>
              <span>Gestión de pedidos</span>
            </a>
          </li>
          @endcan

          @can('gestionar descuentos')
          <li class="mb-1">
            <a href="{{ route('dashboard.descuentos') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
              <i class="fa-solid fa-tags"></i>
              <span>Descuentos</span>
            </a>
          </li>
          @endcan

          @can('ver dashboard')
          <li class="mb-1">
            <a href="{{ route('dashboard.fertilizantes') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
            <i class="fa-solid fa-person-digging"></i>
              <span>Fertilizante</span>
            </a>
          </li>
          @endcan

          @can('ver dashboard')
          <li class="mb-1">
            <a href="{{ route('dashboard.ordenes') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
            <i class="fa-solid fa-umbrella"></i>
              <span>Orden de Producción</span>
            </a>
          </li>
          @endcan

          @can('ver dashboard')
          <li class="mb-1">
            <a href="{{ route('dashboard.cuidados') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
            <i class="fa-solid fa-sun"></i>
              <span>Cuidados</span>
            </a>
          </li>
          @endcan

          @can('ver dashboard')
          <li class="mb-1">
            <a href="{{ route('dashboard.finanzas') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
            <i class="fa-solid fa-coins"></i>
              <span>Finanzas</span>
            </a>
          </li>
          @endcan

          @can('ver dashboard')
          <li class="mb-1">
            <a href="{{ route('dashboard.insumos') }}" class="flex items-center space-x-2 px-3 py-2 bg-{{ $color }}-700 rounded-md">
            <i class="fa-solid fa-coins"></i>
              <span>Insumos</span>
            </a>
          </li>
          @endcan
        </ul>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-white shadow-sm">
        <div class="flex items-center justify-between px-6 py-3">
          <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
              <i class="fas fa-bars"></i>
            </button>
            <h1 class="ml-4 text-2xl font-['Roboto_Condensed'] font-bold text-eprimary tracking-wide">
              @yield('title', 'Dashboard')
            </h1>
          </div>

          <div class="flex items-center space-x-4">
            <div class="relative" x-data="{ open: false }">
              <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User" class="h-8 w-8 rounded-full">
                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
              </button>
              <div x-show="open" @click.away="open = false"
                  class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                  @can('ver dashboard')
                      <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                          Panel Admin
                      </a>
                  @endcan
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                          Cerrar sesión
                      </button>
                  </form>
              </div>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
      </main>

      <footer class="bg-white border-t py-4 px-6">
        <div class="flex justify-between items-center">
          <div>
            <strong>Copyright © {{ date('Y') }}
              <a href="/" class="text-{{ $color }}-600">Plantas Editha</a>.
            </strong> Todos los derechos reservados.
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('dashboard', () => ({
        sidebarOpen: true,
        init() {
          this.handleResize();
          window.addEventListener('resize', this.handleResize.bind(this));
        },
        handleResize() {
          this.sidebarOpen = window.innerWidth >= 1024;
        }
      }));
    });
  </script>
</body>
</html>
