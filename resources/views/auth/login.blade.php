<x-guest-layout>
    @php
        $pref = Auth::user()?->preference;
        $headerColor = $pref?->table_header_color ?? '#1F2937';
        $headerTextColor = $pref?->table_header_text_color ?? '#ffffff';
    @endphp

    <style>
        :root {
            --table-header-color: {{ $headerColor }};
            --table-header-text-color: {{ $headerTextColor }};
        }
    </style>

    {{-- 🔙 Botón Volver igual al botón de "Registrarse" --}}
    <div class="w-full max-w-md mx-auto mb-4">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center px-5 py-2 bg-green-100 border border-green-300 rounded-lg font-semibold text-sm text-green-800 hover:bg-green-200 transition">
            ← Volver
        </a>
    </div>

    {{-- Encabezado de bienvenida --}}
    <div class="text-center mb-6 mt-2">
        <h1 class="text-2xl font-bold text-green-800 flex items-center justify-center gap-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l3-3m-3 3l-3-3" />
            </svg>
            Bienvenido al Vivero 🌱
        </h1>
        <p class="text-sm text-gray-600 mt-1">Ingresa con tu cuenta para seguir creciendo con nosotros</p>
    </div>

    {{-- Estado de sesión --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-green-800" />
            <x-text-input id="email" class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" class="text-green-800" />
            <x-text-input id="password" class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Recordarme -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-green-300 text-green-600 shadow-sm focus:ring-green-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-700">Recuérdame</span>
            </label>
        </div>

        <!-- Acciones -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-6 gap-2">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-green-700 hover:text-green-900 mb-2 sm:mb-0" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
            <div class="flex gap-2">
                <x-primary-button class="bg-green-600 hover:bg-green-700 text-white rounded-lg px-5 py-2">
                    Acceder
                </x-primary-button>
                <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2 bg-green-100 border border-green-300 rounded-lg font-semibold text-sm text-green-800 hover:bg-green-200 transition">
                    Registrarse
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
