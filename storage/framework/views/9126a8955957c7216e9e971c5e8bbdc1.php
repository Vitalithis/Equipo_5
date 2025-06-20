<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $__env->yieldContent('title', 'Plantas Editha | Dashboard'); ?></title>

  <script src="https://cdn.tailwindcss.com"></script>
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans" x-data="dashboard">
  <div class="flex h-screen">

    <?php
        $color = 'green';
        $seccion = 'Panel de Administración';
    ?>

    <div class="bg-<?php echo e($color); ?>-800 text-white w-64 flex-shrink-0" :class="{'-ml-64': !sidebarOpen}">
      <div class="p-4 border-b border-<?php echo e($color); ?>-700">
        <div class="flex items-center space-x-2">
          <img src="<?php echo e(asset('dist/img/logoeditha.png')); ?>" alt="Logo" class="h-20 w-20 rounded-full">
          <span class="text-lg font-semibold"><?php echo e($seccion); ?></span>
        </div>
      </div>
      <nav class="p-4">
        <ul>
          <?php if (\Illuminate\Support\Facades\Blade::check('role', 'soporte')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('admin.clientes.index')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-building"></i>
              <span>Clientes</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver dashboard')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-house"></i>
              <span>Home</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar catálogo')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('dashboard.catalogo')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-seedling"></i>
              <span>Catálogo</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver roles')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('roles.index')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-user-shield"></i>
              <span>Roles</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar usuarios')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('users.index')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-users"></i>
              <span>Usuarios</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar pedidos')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('pedidos.index')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-box-open"></i>
              <span>Gestión de pedidos</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar descuentos')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('dashboard.descuentos')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-tags"></i>
              <span>Descuentos</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar tareas')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('works.index')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-list-check"></i>
              <span>Tareas del Vivero</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar fertilizantes')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('dashboard.fertilizantes')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
            <i class="fa-solid fa-person-digging"></i>
              <span>Fertilizante</span>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar proveedores')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('proveedores.index')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
              <i class="fa-solid fa-truck-field"></i>
              <span>Proveedores</span>
            </a>
          </li>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar cuidados')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('dashboard.cuidados')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
            <i class="fa-solid fa-sun"></i>
              <span>Cuidados</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar finanzas')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('dashboard.finanzas')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
            <i class="fa-solid fa-coins"></i>
              <span>Finanzas</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gestionar insumos')): ?>
          <li class="mb-1">
            <a href="<?php echo e(route('dashboard.insumos')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
            <i class="fa-solid fa-droplet"></i>
              <span>Insumos</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver dashboard')): ?>
            <li class="mb-1">
                <a href="<?php echo e(route('maintenance.index')); ?>" class="flex items
                    -center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
                    <i class="fa-solid fa-tools"></i>
                    <span>Mantenimiento</span>
                </a>
            </li>
          <?php endif; ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver dashboard')): ?>
            <li class="mb-1">
                <a href="<?php echo e(route('dashboard.cotizaciones.index')); ?>" class="flex items-center space-x-2 px-3 py-2 bg-<?php echo e($color); ?>-700 rounded-md">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>Cotizaciones</span>
                </a>
            </li>
            <?php endif; ?>
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
            <h1 class="ml-4 text-2xl font-['Roboto_Condensed'] font-bold text-black tracking-wide">
              <?php echo $__env->yieldContent('title', 'Dashboard'); ?>
            </h1>
          </div>

          <div class="flex items-center space-x-4">
            <div class="relative" x-data="{ open: false }">
              <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                <img src="<?php echo e(asset('dist/img/user2-160x160.jpg')); ?>" alt="User" class="h-8 w-8 rounded-full">
                <span class="hidden md:inline"><?php echo e(Auth::user()->name); ?></span>
              </button>
              <div x-show="open" @click.away="open = false"
                  class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver dashboard')): ?>
                      <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                          Panel Admin
                      </a>
                  <?php endif; ?>
                  <form method="POST" action="<?php echo e(route('logout')); ?>">
                      <?php echo csrf_field(); ?>
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
          <?php if(Auth::user()?->must_change_password): ?>
              <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow-md">
                  ⚠️ <strong>Debes cambiar tu contraseña</strong> antes de continuar usando el sistema.
              </div>
          <?php endif; ?>

          <?php echo $__env->yieldContent('content'); ?>
      </main>

      <footer class="bg-white border-t py-4 px-6 hidden">
        <div class="flex justify-between items-center">
          <div>
            <strong>Copyright © <?php echo e(date('Y')); ?>

              <a href="/" class="text-<?php echo e($color); ?>-600">Plantas Editha</a>.
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

<?php /**PATH D:\Code\Equipo_5\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>