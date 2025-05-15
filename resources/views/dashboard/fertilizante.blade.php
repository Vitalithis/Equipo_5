@extends('layouts.dashboard')

@section('title', 'Lista de Fertilizantes')

@section('content')
<div class="max-w-7xl mx-auto bg-efore" style="background-color:rgb(248,246,244) !important">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Fertilizantes</h2>
            <a href="{{ route('fertilizantes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Añadir Fertilizante</a>
        </div>

        <div class="overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
            <table class="min-w-full bg-white border-0">
                <thead class="bg-eaccent2 text-eprimary uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-6 py-4 text-center">ID</th>
                        <th class="px-6 py-4 text-left">Imagen</th>
                        <th class="px-6 py-4 text-left">Nombre</th>
                        <th class="px-6 py-4 text-left">Tipo</th>
                        <th class="px-6 py-4 text-left">Precio</th>
                        <th class="px-6 py-4 text-left">Stock</th>
                        <th class="px-6 py-4 text-left">Activo</th>
                        <th class="px-6 py-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fertilizantes as $fertilizante)
                        <tr>
                            <td class="px-4 py-2 text-center">{{ $fertilizante->id }}</td>
                            <td class="px-4 py-2">
                                @if($fertilizante->imagen)
                                    <img src="{{ asset('storage/' . $fertilizante->imagen) }}" alt="{{ $fertilizante->nombre }}"
                                        class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400">Sin imagen</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $fertilizante->nombre }}</td>
                            <td class="px-4 py-2">{{ $fertilizante->tipo }}</td>
                            <td class="px-4 py-2">${{ number_format($fertilizante->precio, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $fertilizante->stock }}</td>
                            <td class="px-4 py-2">
                                {{ $fertilizante->activo ? 'Sí' : 'No' }}
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('fertilizantes.edit', $fertilizante->id) }}" class="text-blue-500">Editar</a>
                                <button type="button" class="text-red-500 ml-2"
                                    onclick="openDeleteModal({{ $fertilizante->id }}, '{{ $fertilizante->nombre }}')">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-lg font-bold text-gray-800 mb-4">¿Eliminar fertilizante?</h2>
        <p class="text-gray-700 mb-4">
            ¿Estás seguro que deseas eliminar el fertilizante <span id="modalFertilizanteName" class="font-semibold"></span>?
        </p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(id, nombre) {
        document.getElementById('modalFertilizanteName').textContent = nombre;
        document.getElementById('deleteForm').action = `/dashboard/fertilizantes/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
@endsection
