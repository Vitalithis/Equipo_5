<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Poppins&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $pref = Auth::user()?->preference;
        $logo = $pref?->logo_image ? asset('storage/logos/' . $pref->logo_image) : asset('dist/img/logoeditha.png');
    @endphp
</head>
<body class="font-['Poppins'] bg-green-50 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md mx-auto">
        {{-- Logo centrado, redondeado con sombra --}}
        <div class="flex justify-center mb-6">
            <a href="{{ url('/home') }}">
                <img src="{{ $logo }}" alt="Logo Vivero" class="h-40 w-40 rounded-full shadow-lg border border-green-300 bg-white p-2">
            </a>
        </div>

        {{-- Contenedor del formulario --}}
        <div class="bg-white shadow-xl rounded-xl p-8 border border-green-200">
            {{ $slot }}
        </div>

        {{-- Footer sutil --}}
        <p class="text-center text-xs text-gray-500 mt-6">© {{ date('Y') }} Plantas Editha 🌿</p>
    </div>

</body>
</html>
