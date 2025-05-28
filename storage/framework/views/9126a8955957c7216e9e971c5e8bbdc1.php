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

      <div class="p-4 border-b border-<?php echo e($color); ?>-700">
        <div class="flex items-center space-x-3">
          <img src="<?php echo e(asset('dist/img/user2-160x160.jpg')); ?>" alt="User" class="h-10 w-10 rounded-full">
          <div>
            <div class="font-medium"><?php echo e(Auth::user()->name); ?></div>
            <?php $rol = Auth::user()->getRoleNames()->first(); ?>
            <div class="text-sm text-white bg-<?php echo e($color); ?>-600 rounded-full px-2 py-0.5 inline-block mt-1">
              <?php echo e($rol ?? 'Sin rol'); ?>

            </div>
          </div>
        </div>
      </div>

      <nav class="p-4">
        <ul>
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
        <?php echo $__env->yieldContent('content'); ?>
      </main>

      <footer class="bg-white border-t py-4 px-6">
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