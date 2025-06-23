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
<div x-data="{ drawerOpen: false, userdrawerOpen: false }">

    <nav class="bg-white px-6 md:px-20 py-2 flex items-center justify-between font-roboto_condensed  sticky top-0 z-50"">
        <!-- Logo -->
            <!-- Ícono Burger (sólo en móvil) -->
        <button @click=" drawerOpen=!drawerOpen" class="md:hidden">
        <img src="{{ asset('/storage/images/list.svg') }}" alt="Menú" class="w-8 h-8 mx-6" />
        </button>
        <div class=" flex-shrink-0">
            <img src="{{ asset('/storage/images/logo.png') }}" alt="Logo" width="130" height="80"
                class="h-14 my-2 md:my-0   md:h-[80px] w-auto" />
        </div>

        <!-- Links en escritorio -->
        <ul class="hidden md:flex space-x-10 list-none">
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['href'] }}" class="text-black hover:text-gray-300 transition-colors duration-200">
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Botón login (escritorio) -->
        <div class="relative hidden md:block" x-data="{ open: false }">
            <button @click="open = !open" class="focus:outline-none">
                <img src="{{ asset('/storage/images/navlogin.svg') }}" alt="Login" width="50" height="50"
                    class="h-[50px] w-auto cursor-pointer" />
            </button>

            <div x-show="open" @click.outside="open = false"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50" x-cloak>
                <div class="py-1">
                    @auth
                        @can('ver dashboard')
                            <a href="/dashboard" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Dashboard</a>
                        @endcan

                        <a href="/cart" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Carrito</a>
                        <a href="/cotizacion" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Mis Cotizaciones</a>
                        <a href="{{ route('compras.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Mis
                            Compras</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                Cerrar sesión
                            </button>
                        </form>
                    @else
                        <a href="/login" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="/register" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Registrarse</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>


    </nav>
    <!-- Drawer lateral -->
    <div class="fixed inset-0 z-40 bg-black bg-opacity-50 transition-opacity duration-300" x-show="drawerOpen"
        x-transition.opacity @click.self="drawerOpen = false" x-cloak>
        <div class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out"
            x-show="drawerOpen" x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full" x-cloak>
            <div class="p-6">
                <!-- Cerrar -->
                <button @click="drawerOpen = false" class="mb-4 text-gray-500 hover:text-black">
                    ✕ Cerrar
                </button>

                <!-- Links -->
                <ul class="space-y-4">
                    @foreach ($links as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="block text-black hover:text-blue-500 text-lg"
                                @click="drawerOpen = false">
                                {{ $link['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Extra -->
                <!-- Usuario autenticado o no -->
                <div class="mt-6 border-t pt-4 space-y-2 text-black text-lg">
                    @auth
                        @can('ver dashboard')
                            <a href="/dashboard" class="block px-2 py-2 hover:text-blue-500">Dashboard</a>
                        @endcan

                        <a href="/cart" class="block px-2 py-2 hover:text-blue-500">Carrito</a>
                        <a href="/cotizacion" class="block px-2 py-2 hover:text-blue-500">Mis Cotizaciones</a>
                        <a href="{{ route('compras.index') }}" class="block px-2 py-2 hover:text-blue-500">Mis Compras</a>

                        <form method="POST" action="{{ route('logout') }}" class="px-2">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 hover:text-red-500">
                                Cerrar sesión
                            </button>
                        </form>
                    @else
                        <a href="/login" class="block px-2 py-2 hover:text-blue-500">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="/register" class="block px-2 py-2 hover:text-blue-500">Registrarse</a>
                        @endif
                    @endauth
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<!-- AlpineJS -->
<script src="//unpkg.com/alpinejs" defer></script>
<style>[x-cloak] { display: none !important; }</style>
