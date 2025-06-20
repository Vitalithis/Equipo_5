<!DOCTYPE html>
<html lang="es">

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
    <!-- Tailwind + Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="flex flex-col min-h-screen font-roboto_sans
    {{ request()->routeIs('home') || request()->is('/') ? 'bg-white' : 'bg-gray-100' }}">
    {{-- Navbar --}}
    @include('components.navbar')
    {{-- Contenido principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')


    <!-- Sección para agregar scripts personalizados -->
    @stack('scripts')
</body>

</html>
