<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Plantas Editha | Dashboard')</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Alpine JS -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans" x-data="dashboard">
  <div class="flex h-screen">

    <!-- Sidebar -->
    <div class="bg-green-800 text-white w-64 flex-shrink-0" :class="{'-ml-64': !sidebarOpen}" class="lg:-ml-0">
      <div class="p-4 border-b border-green-700">
        <div class="flex items-center space-x-2">
          <img src="{{ asset('dist/img/logoeditha.png') }}" alt="Logo" class="h-8 w-8 rounded-full">
          <span class="text-lg font-semibold">Sala Venta</span>
        </div>
      </div>

      <div class="p-4 border-b border-green-700">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User" class="h-10 w-10 rounded-full">
          <div>
            <div class="font-medium">{{ Auth::user()->name }}</div>
            <div class="text-green-200 text-sm">Administrador</div>
          </div>
        </div>
      </div>

      <nav class="p-4">
        <ul>
          <li class="mb-1">
            <a href="{{ route('dashboard.catalogo') }}" class="flex items-center space-x-2 px-3 py-2 bg-green-700 rounded-md">
              <i class="fa-solid fa-gauge"></i>
              <span>Catalogo</span>
            </a>
          </li>
          <!-- Más elementos del menú -->
          <li class="mb-1">
            <a href="#" class="flex items-center space-x-2 px-3 py-2 bg-green-700 rounded-md">
              <i class="fa-regular fa-circle-user"></i>
              <span>Roles</span>
            </a>
          </li>
          <li class="mb-1">
            <a href="{{ route('pedidos.index') }}" class="flex items-center space-x-2 px-3 py-2 bg-green-700 rounded-md">
              <i class="fa-solid fa-gauge"></i>
              <span>Gestión de pedidos</span>
            </a>
          </li>
            <li class="mb-1">
                <a href="{{ route('dashboard.descuentos') }}" class="flex items
                    center space-x-2 px-3 py-2 bg-green-700 rounded-md">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Descuentos</span>
                </a>
            </li>
            <li class="mb-1">
                <a href="{{ route('dashboard.fertilizantes') }}" class="flex items
                    center space-x-2 px-3 py-2 bg-green-700 rounded-md">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Fertilizante</span>
                </a>
            </li>
        </ul>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Top Navigation -->
      <header class="bg-white shadow-sm">
        <div class="flex items-center justify-between px-6 py-3">
          <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
              <i class="fas fa-bars"></i>
            </button>
            <h1 class="ml-4 text-xl font-semibold text-gray-800">Dashboard</h1>
          </div>

          <div class="flex items-center space-x-4">
            <!-- User Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
              <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User" class="h-8 w-8 rounded-full">
                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
              </button>

              <div x-show="open" @click.away="open = false"
                  class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">

                  @role('admin|superadmin')
                      <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sala Venta</a>
                      <a href="{{ route('/dashboard2') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Fabrica</a>
                  @endrole

                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>

                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                          Cerrar sesión
                      </button>
                  </form>
              </div>

            </div>
          </div>
        </div>
      </header>

      <!-- Main Content Area -->
      <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
      </main>

      <!-- Footer -->
      <footer class="bg-white border-t py-4 px-6">
        <div class="flex justify-between items-center">
          <div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="/" class="text-green-600">Plantas Editha</a>.</strong> Todos los derechos reservados.
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
          if (window.innerWidth < 1024) {
            this.sidebarOpen = false;
          } else {
            this.sidebarOpen = true;
          }
        }
      }));
    });
  </script>
</body>
</html>
