@php
    $pref = Auth::user()?->preference;
    $navbarColor = $pref?->navbar_color ?? '#FFFFFF';
    $navbarTextColor = $pref?->navbar_text_color ?? '#000000';
    $logo = $pref?->logo_image ? asset('storage/logos/' . $pref->logo_image) : asset('/storage/images/logo.png');

    $publicLinks = [
        ['name' => 'Inicio', 'href' => '/'],
        ['name' => '¿Quiénes Somos?', 'href' => '/home#quienes-somos'],
        ['name' => 'Productos', 'href' => '/productos'],
        ['name' => 'Preguntas Frecuentes', 'href' => '/home#faq'],
        ['name' => 'Contacto', 'href' => '/home#contact'],
    ];
@endphp

<div class="fixed z-50"  x-data="{ drawerOpen: false, userMenuOpen: false, mobileMenuOpen: false }">
    <nav class=" top-50 z-0 bg-[var(--navbar-color)] px-6 md:px-20 py-2 flex items-center justify-between font-roboto_condensed w-screen"
         style="background-color: {{ $navbarColor }}; color: {{ $navbarTextColor }}">
        <!-- Botón hamburguesa móvil -->
        <button @click="drawerOpen = true" class="md:hidden">
            <img src="{{ asset('/storage/images/list.svg') }}" alt="Menú" class="w-8 h-8" />
        </button>

        <!-- Logo -->
        <div class="flex-shrink-0">
            <img src="{{ $logo }}" alt="Logo" class="h-[80px] w-auto" loading="lazy" />
        </div>

        <!-- Links escritorio -->
        <ul class="hidden md:flex space-x-10 list-none">
            @foreach ($publicLinks as $link)
                <li>
                    <a href="{{ $link['href'] }}" class="hover:opacity-80 transition duration-200"
                       style="color: {{ $navbarTextColor }}">
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Menú de usuario (escritorio) -->
        <div class="relative hidden md:block" x-data="{ open: false }">
            @auth
                <button @click="open = !open" class="flex items-center gap-2" style="color: {{ $navbarTextColor }}">
                    <img src="{{ $pref?->profile_image ? asset('storage/profiles/' . $pref->profile_image) : asset('/dist/img/user2-160x160.jpg') }}"
                         class="h-8 w-8 rounded-full object-cover">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak
                     class="absolute right-0 mt-2 w-52 bg-white rounded-md shadow-lg z-50 text-black">
                    @can('ver dashboard')
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Panel Admin</a>
                    @endcan
                    <a href="{{ route('cotizacion.index') }}" class="block px-4 py-2 hover:bg-gray-100">Mis Cotizaciones</a>
                    <a href="{{ route('cart.index') }}" class="block px-4 py-2 hover:bg-gray-100">Mi Carrito</a>
                    <a href="{{ route('compras.index') }}" class="block px-4 py-2 hover:bg-gray-100">Mis Pedidos</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Cerrar sesión</button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-4" style="color: {{ $navbarTextColor }}">
                    <a href="{{ route('login') }}" class="hover:underline text-sm">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="hover:underline text-sm">Registrar</a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Drawer lateral -->
    <div class="fixed inset-0 z-40 bg-black bg-opacity-50" x-show="drawerOpen" @click.self="drawerOpen = false" x-cloak x-transition.opacity>
        <div class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out"
             x-show="drawerOpen" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full" x-cloak>
            <div class="p-6 space-y-4 z-60">
                <button @click="drawerOpen = false" class="text-gray-500 hover:text-black mb-4">✕ Cerrar</button>
                @foreach ($publicLinks as $link)
                    <a href="{{ $link['href'] }}" class="block text-black hover:text-blue-500 text-lg"
                       @click="drawerOpen = false">
                        {{ $link['name'] }}
                    </a>
                @endforeach
                <hr class="my-4">
                @auth
                    @can('ver dashboard')
                        <a href="{{ route('dashboard') }}" class="block hover:text-blue-500">Dashboard</a>
                    @endcan
                    <a href="{{ route('cart.index') }}" class="block hover:text-blue-500">Carrito</a>
                    <a href="{{ route('cotizacion.index') }}" class="block hover:text-blue-500">Mis Cotizaciones</a>
                    <a href="{{ route('compras.index') }}" class="block hover:text-blue-500">Mis Pedidos</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left hover:text-red-500">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block hover:text-blue-500">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="block hover:text-blue-500">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- AlpineJS -->
<script src="//unpkg.com/alpinejs" defer></script>
<style>[x-cloak] { display: none !important; }</style>
