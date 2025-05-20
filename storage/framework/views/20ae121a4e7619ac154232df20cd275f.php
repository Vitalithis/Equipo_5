<?php
    $links = [
        ['name' => 'Inicio', 'href' => '/'],
        ['name' => '¿Quiénes Somos?', 'href' => '/nosotros'],
        ['name' => 'Productos', 'href' => '/productos'],
        ['name' => 'Preguntas Frecuentes', 'href' => '/faq'],
        ['name' => 'Contacto', 'href' => '/contacto'],
    ];
?>

<nav
    class="bg-white px-6 md:px-20 py-2 flex items-center justify-between font-['Roboto_Condensed']  sticky top-0 z-50"
    x-data="{ menuOpen: false, userMenuOpen: false }"
>
    <!-- Logo -->
    <div class="flex-shrink-0">
        <img
            src="<?php echo e(asset('/storage/images/logo.png')); ?>"
            alt="Logo"
            width="130"
            height="80"
            class="h-[80px] w-auto"
        />
    </div>

    <!-- Links en escritorio -->
    <ul class="hidden md:flex space-x-10 list-none">
        <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a
                    href="<?php echo e($link['href']); ?>"
                    class="text-black hover:text-gray-300 transition-colors duration-200"
                >
                    <?php echo e($link['name']); ?>

                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <!-- Botón login (escritorio) -->
    <div class="relative hidden md:block" x-data="{ open: false }">
        <button @click="open = !open" class="focus:outline-none">
            <img
                src="<?php echo e(asset('/storage/images/navlogin.svg')); ?>"
                alt="Login"
                width="50"
                height="50"
                class="h-[50px] w-auto cursor-pointer"
            />
        </button>
        <div
            x-show="open"
            @click.outside="open = false"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50"
            x-cloak
        >
            <div class="py-1">
                <a href="/registro" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Registrarse</a>
                <a href="/login" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Iniciar Sesión</a>
            </div>
        </div>
    </div>

    <!-- Ícono Burger (sólo en móvil) -->
    <button @click="menuOpen = !menuOpen" class="md:hidden">
        <img
            src="<?php echo e(asset('/storage/images/list.svg')); ?>"
            alt="Menú"
            class="w-8 h-8"
        />
    </button>
</nav>

<!-- Menú móvil desplegable -->
<div
    x-show="menuOpen"
    x-transition
    class="md:hidden bg-white px-6 pt-4 pb-6 space-y-4 shadow-md"
    x-cloak
>
    <ul class="space-y-2">
        <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a
                    href="<?php echo e($link['href']); ?>"
                    class="block text-black hover:text-gray-500 text-lg"
                >
                    <?php echo e($link['name']); ?>

                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <div class="border-t border-gray-300 pt-4 space-y-2">
        <a href="/registro" class="block text-black hover:text-gray-500 text-lg">Registrarse</a>
        <a href="/login" class="block text-black hover:text-gray-500 text-lg">Iniciar Sesión</a>
    </div>
</div>

<!-- AlpineJS -->
<script src="//unpkg.com/alpinejs" defer></script>

<style>
    [x-cloak] { display: none !important; }
</style>
<?php /**PATH D:\Code\Equipo_5\resources\views/components/navbar.blade.php ENDPATH**/ ?>