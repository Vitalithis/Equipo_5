<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Plantas Editha | Dashboard</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
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
        <img src="dist/img/logoeditha.png" alt="Logo" class="h-8 w-8 rounded-full">
        <span class="text-lg font-semibold">Sala Venta</span>
      </div>
    </div>
    
    <div class="p-4 border-b border-green-700">
      <div class="flex items-center space-x-3">
        <img src="dist/img/user2-160x160.jpg" alt="User" class="h-10 w-10 rounded-full">
        <div>
          <div class="font-medium">{{ Auth::user()->name }}</div>
          <div class="text-green-200 text-sm">Administrador</div>
        </div>
      </div>
    </div>
    
    <nav class="p-4">
      <ul>
        <li class="mb-1">
          <a href="{{ route('home') }}" class="flex items-center space-x-2 px-3 py-2 bg-green-700 rounded-md">
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
          <!-- Notifications Dropdown -->
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none relative">
              <i class="fas fa-bell"></i>
              <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
            </button>
            
            <div x-show="open" @click.away="open = false" 
                 class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50">
              <div class="p-4 border-b">
                <h3 class="text-lg font-medium">Notificaciones (3)</h3>
              </div>
              <div class="divide-y divide-gray-100">
                <!-- Ejemplo de notificación -->
                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full">
                      <i class="fas fa-shopping-cart text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                      <p class="text-sm font-medium text-gray-900">Nuevo pedido</p>
                      <p class="text-sm text-gray-500">Hace 10 minutos</p>
                    </div>
                  </div>
                </a>
                <!-- Más notificaciones -->
              </div>
              <a href="#" class="block px-4 py-2 text-sm text-center text-blue-600 bg-gray-50 hover:bg-gray-100">
                Ver todas
              </a>
            </div>
          </div>
          
          <!-- Messages Dropdown -->
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none relative">
              <i class="fas fa-envelope"></i>
              <span class="absolute -top-1 -right-1 h-4 w-4 bg-blue-500 rounded-full text-xs text-white flex items-center justify-center">5</span>
            </button>
            
            <div x-show="open" @click.away="open = false" 
                 class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50">
              <div class="p-4 border-b">
                <h3 class="text-lg font-medium">Mensajes (5)</h3>
              </div>
              <div class="divide-y divide-gray-100">
                <!-- Ejemplo de mensaje -->
                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                  <div class="flex items-start">
                    <img src="dist/img/user2-160x160.jpg" alt="User" class="h-10 w-10 rounded-full">
                    <div class="ml-3">
                      <p class="text-sm font-medium text-gray-900">Juan Pérez</p>
                      <p class="text-sm text-gray-500">¿Tenemos stock de rosas?</p>
                      <p class="text-xs text-gray-400">Hace 30 minutos</p>
                    </div>
                  </div>
                </a>
                <!-- Más mensajes -->
              </div>
              <a href="#" class="block px-4 py-2 text-sm text-center text-blue-600 bg-gray-50 hover:bg-gray-100">
                Ver todos
              </a>
            </div>
          </div>
          
          <!-- User Profile Dropdown -->
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
              <img src="dist/img/user2-160x160.jpg" alt="User" class="h-8 w-8 rounded-full">
              <span class="hidden md:inline">{{ Auth::user()->name }}</span>
            </button>
            
            <div x-show="open" @click.away="open = false" 
                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Roles</a>
              <a href="{{ route('dashboard2') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Planta Producción</a>              
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
      <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm p-6">

          
          <!-- Contenido del dashboard -->
          <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tarjeta de Ventas -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-500 hover:shadow-md transition-shadow">
              <h3 class="text-gray-500 uppercase text-sm font-semibold">Ventas</h3>
              <p class="text-2xl font-bold mt-2">$12,345</p>
              <a href="#" class="mt-3 inline-flex items-center text-blue-500 hover:text-blue-700">
                Ver detalles <i class="fas fa-arrow-right ml-1"></i>
              </a>
            </div>
            
            <!-- Tarjeta de Productos -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-green-500 hover:shadow-md transition-shadow">
              <h3 class="text-gray-500 uppercase text-sm font-semibold">Productos</h3>
              <p class="text-2xl font-bold mt-2">142</p>
              <a href="#" class="mt-3 inline-flex items-center text-green-500 hover:text-green-700">
                Ver lista <i class="fas fa-arrow-right ml-1"></i>
              </a>
            </div>
            
            <!-- Tarjeta de Clientes -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-yellow-500 hover:shadow-md transition-shadow">
              <h3 class="text-gray-500 uppercase text-sm font-semibold">Clientes</h3>
              <p class="text-2xl font-bold mt-2">56</p>
              <a href="#" class="mt-3 inline-flex items-center text-yellow-500 hover:text-yellow-700">
                Ver clientes <i class="fas fa-arrow-right ml-1"></i>
              </a>
            </div>
            <!-- Tarjeta de Ventas -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-500 hover:shadow-md transition-shadow">
              <h3 class="text-gray-500 uppercase text-sm font-semibold">Ventas</h3>
              <p class="text-2xl font-bold mt-2">$12,345</p>
              <a href="#" class="mt-3 inline-flex items-center text-blue-500 hover:text-blue-700">
                Ver detalles <i class="fas fa-arrow-right ml-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
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
        // Verificar el tamaño de pantalla al cargar
        this.handleResize();
        // Escuchar cambios de tamaño
        window.addEventListener('resize', this.handleResize.bind(this));
      },
      
      handleResize() {
        // Cerrar sidebar en móviles por defecto
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