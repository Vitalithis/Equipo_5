@php
    $links = [
        ['name' => 'Inicio', 'href' => '/'],
        ['name' => '¿Quiénes Somos?', 'href' => '/home#quienes-somos'],
        ['name' => 'Productos', 'href' => '/productos'],
        ['name' => 'Preguntas Frecuentes', 'href' => '/home#faq'],
        ['name' => 'Contacto', 'href' => '/home#contact'],
    ];

    $logo = auth()->user()->logo ?? null;
@endphp

<nav class="bg-white dark:bg-gray-800 px-6 md:px-20 py-2 flex items-center justify-between font-roboto_condensed sticky top-0 z-50"
    x-data="{ menuOpen: false, userMenuOpen: false }">

    <!-- Logo -->
    <div class="flex-shrink-0">
        <img src="{{ $logo ? asset('storage/' . $logo) : asset('/storage/images/logo.png') }}"
             alt="Logo"
             class="h-[80px] w-auto"
             loading="lazy" />
    </div>

    <!-- Links escritorio -->
    <ul class="hidden md:flex space-x-10 list-none">
        @foreach ($links as $link)
            <li>
                <a href="{{ $link['href'] }}" class="text-black dark:text-gray-200 hover:text-eaccent transition duration-200">
                    {{ $link['name'] }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Botón login -->
    <div class="relative hidden md:block" x-data="{ open: false }">
        <button @click="open = !open" class="focus:outline-none">
            <img src="{{ asset('/storage/images/navlogin.svg') }}" alt="Login"
                 class="h-[50px] w-auto cursor-pointer" />
        </button>
        <div x-show="open" @click.outside="open = false"
             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-50" x-cloak>
            <div class="py-1 text-gray-800 dark:text-gray-100">
                @auth
                    @can('ver dashboard')
                        <a href="/dashboard" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Dashboard</a>
                    @endcan
                    <a href="/cart" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Carrito</a>
                    <a href="/cotizacion" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Mis Cotizaciones</a>
                    <a href="{{ route('compras.index') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Mis Compras</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block px-4 py-2 w-full text-left hover:bg-gray-100 dark:hover:bg-gray-600">Cerrar sesión</button>
                    </form>
                @else
                    <a href="/login" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="/register" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Registrarse</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Móvil -->
    <button @click="menuOpen = !menuOpen" class="md:hidden">
        <img src="{{ asset('/storage/images/list.svg') }}" alt="Menú" class="w-8 h-8" />
    </button>
</nav>

<!-- Menú móvil -->
<div x-show="menuOpen" x-transition class="md:hidden bg-white dark:bg-gray-800 px-6 pt-4 pb-6 space-y-4 shadow-md" x-cloak>
    <ul class="space-y-2">
        @foreach ($links as $link)
            <li>
                <a href="{{ $link['href'] }}" class="block text-black dark:text-gray-200 hover:text-eaccent text-lg">
                    {{ $link['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
<style>[x-cloak] { display: none !important; }</style>
