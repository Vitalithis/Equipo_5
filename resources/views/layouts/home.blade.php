@php
    $pref = Auth::check() ? Auth::user()->preference : null;
    $navbarColor = $pref?->navbar_color ?? '#FFFFF'; // color por defecto: gris oscuro
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

<body class="min-h-screen flex flex-col transition-all duration-300" :class="[fontFamily, backgroundColor, textColor]">

    {{-- Navbar reutilizable con color dinámico --}}
    @include('components.navbar')

    {{-- Contenido principal (ocupa espacio restante) --}}
    <main class="flex-grow flex flex-col justify-center">
        @yield('content')
    </main>

    {{-- Footer general (siempre abajo) --}}
    @include('components.footer')

    @stack('scripts')
</body>
</html>
