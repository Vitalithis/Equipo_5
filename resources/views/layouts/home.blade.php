@php
    $pref = Auth::check() ? Auth::user()->preference : null;
    $navbarColor = $pref?->navbar_color ?? '#1F2937'; // color por defecto: gris oscuro
@endphp

<!DOCTYPE html>
<html lang="es" x-data="themeConfig()" :class="colorMode">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Plantas Editha')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Colores dinámicos --}}
    <style>
        :root {
            --navbar-color: {{ $navbarColor }};
            --navbar-text-color: {{ $pref?->navbar_text_color ?? '#000000' }};

        }
    </style>
</head>

<body :class="[fontFamily, backgroundColor, textColor, 'transition-all', 'duration-300', 'min-h-screen', 'flex', 'flex-col']">

    {{-- Navbar reutilizable con color dinámico --}}
    @include('components.navbar')
    
    {{-- Contenido principal (ocupa espacio restante) --}}
    <main class="flex-1 pt-24">
        @yield('content')
    </main>

    {{-- Footer general --}}
    @include('components.footer')

    @stack('scripts')

    @push('scripts')
    <script>
    function ajustarFooter() {
        const main = document.querySelector('main');
        const footer = document.querySelector('footer');
        if (!main || !footer) return;
        // Quitar margen previo
        footer.style.marginTop = '';
        // Calcular espacio disponible
        const windowHeight = window.innerHeight;
        const bodyRect = document.body.getBoundingClientRect();
        const mainRect = main.getBoundingClientRect();
        const footerRect = footer.getBoundingClientRect();
        const espacioOcupado = mainRect.top + main.offsetHeight + footer.offsetHeight;
        if (espacioOcupado < windowHeight) {
            footer.style.marginTop = (windowHeight - espacioOcupado) + 'px';
        }
    }
    window.addEventListener('DOMContentLoaded', ajustarFooter);
    window.addEventListener('resize', ajustarFooter);
    </script>
    @endpush
</body>
</html>
