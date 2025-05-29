@extends('layouts.dashboard')

@section('title', 'Registrar Fertilización')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto font-['Roboto'] text-gray-800">
    <a href="{{ route('dashboard.fertilizantes') }}" class="flex items-center text-green-700 hover:text-green-800 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
        Volver a Fertilizantes
    </a>

    <h2 class="text-2xl font-semibold mb-4">Registrar Aplicación de Fertilizante</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif


    @if($ultimasFertilizaciones->count())
    <div class="mb-6 p-4 border border-gray-200 rounded bg-gray-50 text-sm text-gray-700">
        <p class="mb-2 font-semibold text-green-700">Últimas fertilizaciones registradas:</p>
        <ul class="list-disc list-inside">
            @foreach($ultimasFertilizaciones as $f)
                <li>
                    {{ \Carbon\Carbon::parse($f->fecha_aplicacion)->format('d/m/Y') }}:
                    {{ $f->producto->nombre }} con {{ $f->fertilizante->nombre }} ({{ $f->dosis_aplicada ?? 'sin dosis' }})
                </li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('fertilizations.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        <div>
            <label for="producto_id" class="block text-sm font-medium mb-1">Producto</label>
            <select name="producto_id" id="producto_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                <option value="">Selecciona un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="fertilizante_id" class="block text-sm font-medium mb-1">Fertilizante</label>
            <select name="fertilizante_id" id="fertilizante_id" required
        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
    <option value="">Selecciona un fertilizante</option>
    @foreach($fertilizantes as $fertilizante)
        <option value="{{ $fertilizante->id }}" {{ (old('fertilizante_id', $fertilizante_id ?? '') == $fertilizante->id) ? 'selected' : '' }}>
            {{ $fertilizante->nombre }}
        </option>
    @endforeach
</select>
        </div>

        <div>
            <label for="fecha_aplicacion" class="block text-sm font-medium mb-1">Fecha de Aplicación</label>
            <input type="date" name="fecha_aplicacion" id="fecha_aplicacion" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label for="dosis_aplicada" class="block text-sm font-medium mb-1">Dosis Aplicada</label>
            <input type="text" name="dosis_aplicada" id="dosis_aplicada"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>
        <script>
    function actualizarDosis() {
        var select = document.getElementById('fertilizante_id');
        var dosis = select.options[select.selectedIndex].getAttribute('data-dosis');
        document.getElementById('dosis_aplicada').value = dosis || '';
    }
</script>

        <div>
            <label for="notas" class="block text-sm font-medium mb-1">Notas</label>
            <textarea name="notas" id="notas" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"></textarea>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                Registrar Aplicación
            </button>
        </div>
    </form>
</div>
@endsection
