<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Plantas Editha')</title>

    <!-- Aquí puedes cargar tus estilos generales -->
    @vite('resources/css/app.css')

    <!-- Sección para agregar estilos personalizados -->
    @stack('styles')
</head>
<body class="bg-white dark:bg-gray-900 flex flex-col min-h-screen">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Contenido principal --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <!-- Scripts generales -->
    @vite('resources/js/app.js')

    <!-- Sección para agregar scripts personalizados -->
    @stack('scripts')
</body>
</html>
