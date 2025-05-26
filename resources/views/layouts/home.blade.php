<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Plantas Editha')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind + Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="0 flex flex-col min-h-screen">

    {{-- Navbar --}}
    @include('components.navbar')
    {{-- Contenido principal --}}
    <main >
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')


    <!-- Sección para agregar scripts personalizados -->
    @stack('scripts')
</body>
</html>
