<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- 🎨 Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed&family=Inter&family=Poppins&family=Montserrat&family=Open+Sans&family=Nunito&display=swap" rel="stylesheet">

    {{-- ✅ Tailwind + Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 🔄 Estilos dinámicos desde preferencias --}}
    @php
        $pref = Auth::check() ? Auth::user()->preference : null;
        $accentColor = $pref?->accent_color ?? '#10B981';
        $backgroundColor = $pref?->background_color ?? '#F3F4F6';
        $tableHeaderColor = $pref?->table_header_color ?? '#D1D5DB';
        $navbarColor = $pref?->navbar_color ?? '#1F2937';
        $navbarTextColor = $pref?->navbar_text_color ?? '#FFFFFF';
        $fontClass = match($pref?->font ?? 'roboto') {
            'inter' => "font-['Inter']",
            'poppins' => "font-['Poppins']",
            'montserrat' => "font-['Montserrat']",
            'opensans' => "font-['Open Sans']",
            'nunito' => "font-['Nunito']",
            default => "font-['Roboto']",
        };
        $fontSize = $pref?->font_size ?? 'text-base';
        $logo = $pref?->logo_image ? asset('storage/logos/' . $pref->logo_image) : asset('dist/img/logoeditha.png');
        $isDark = $pref?->theme_mode === 'dark' || ($pref?->theme_mode === 'auto' && request()->cookie('prefers_dark') === 'true');
    @endphp

    @if ($pref?->theme_mode === 'auto')
        <script>
            if (!document.cookie.includes("prefers_dark")) {
                document.cookie = "prefers_dark=" + (window.matchMedia('(prefers-color-scheme: dark)').matches ? "true" : "false");
                location.reload();
            }
        </script>
    @endif

    <style>
        :root {
            --accent-color: {{ $accentColor }};
            --background-color: {{ $backgroundColor }};
            --table-header-color: {{ $tableHeaderColor }};
            --navbar-color: {{ $navbarColor }};
            --navbar-text-color: {{ $navbarTextColor }};
        }

        body {
            background-color: var(--background-color);
        }
    </style>
</head>
<body class="font-sans antialiased bg-efore dark:bg-gray-900">

<!-- Pruebas -->
 <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>


    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

<body class="antialiased {{ $fontClass }} {{ $fontSize }} {{ $isDark ? 'dark' : '' }}">

    <div class="min-h-screen flex flex-col">

        {{-- 🔼 Navbar general para paneles --}}
        @include('components.navbar')

        {{-- 💬 Encabezado (opcional) --}}
        @if (isset($header))
            <header class="bg-[var(--navbar-color)] text-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- 📄 Contenido --}}
        <main class="flex-1 container mx-auto px-4 py-8">
            @yield('content')
        </main>

        {{-- 🔻 Footer con logo dinámico --}}
        <footer class="bg-[var(--accent-color)] text-white">
            <div class="max-w-screen-xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ $logo }}" alt="Logo" class="h-10 w-auto">
                    <span class="text-sm">Plantas Editha – Naturaleza con amor 🌿</span>
                </div>
                <div class="text-xs mt-4 md:mt-0 text-white/80">
                    © {{ date('Y') }} Plantas Editha. Todos los derechos reservados.
                </div>
            </div>
        </footer>

    </div>

</body>
</html>
