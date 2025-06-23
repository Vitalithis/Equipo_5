<x-guest-layout>
    @php
        $pref = Auth::user()?->preference;
        $headerColor = $pref?->table_header_color ?? '#1F2937';
        $headerTextColor = $pref?->table_header_text_color ?? '#ffffff';
        $logo = $pref?->logo_image ? asset('storage/logos/' . $pref->logo_image) : asset('dist/img/logoeditha.png');
    @endphp

    <style>
        :root {
            --table-header-color: {{ $headerColor }};
            --table-header-text-color: {{ $headerTextColor }};
        }
    </style>

    {{-- 🔙 Botón Volver --}}
    <div class="w-full max-w-md mx-auto mb-4">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center px-5 py-2 bg-green-100 border border-green-300 rounded-lg font-semibold text-sm text-green-800 hover:bg-green-200 transition">
            ← Volver
        </a>
    </div>

    {{-- Encabezado --}}
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-green-800 flex items-center justify-center gap-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l3-3m-3 3l-3-3" />
            </svg>
            Recupera tu acceso 🍃
        </h1>
        <p class="text-sm text-gray-600 mt-1">Te enviaremos un enlace para restablecer tu contraseña</p>
    </div>

    {{-- Estado de sesión --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-green-800" />
            <x-text-input id="email"
                          class="block mt-1 w-full border-green-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                          type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Botón --}}
        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="bg-green-600 hover:bg-green-700 text-white rounded-lg px-5 py-2">
                {{ __('Enviar enlace de recuperación') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
