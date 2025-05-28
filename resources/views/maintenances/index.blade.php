@extends('layouts.dashboard')

@section('title', 'Reportes de Mantención')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="max-w-7xl mx-auto font-['Roboto'] text-gray-800">
    <div class="rounded-lg shadow-sm p-6">
        <div class="mb-4 flex justify-between items-center">
            <h1 class="text-xl font-['Roboto_Condensed']">Reportes de Mantención</h1>

            @can('gestionar infraestructura')
                <a href="{{ route('maintenance.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Nuevo Reporte
                </a>
            @endcan
        </div>

        <div class="overflow-x-auto rounded-xl border">
            <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
                <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-4 py-3">Título</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Costo</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y font-['Roboto']">
                    @foreach($maintenances as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item->title }}</td>
                            <td class="px-4 py-2">{{ ucfirst($item->status) }}</td>
                            <td class="px-4 py-2">{{ $item->updated_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-2">${{ number_format($item->cost, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                @can('gestionar infraestructura')
                                    <a href="{{ route('maintenance.edit', $item->id) }}"
                                        class="text-blue-600 hover:underline text-sm">Editar</a>
                                    <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ $item->title }}')"
                                        class="text-red-600 hover:underline text-sm ml-2">Eliminar</button>
                                @else
                                    <span class="text-gray-500 italic text-sm">Solo lectura</span>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">{{ $maintenances->links() }}</div>
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
        <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">¿Eliminar reporte?</h2>
        <p class="text-gray-700 mb-4">¿Deseas eliminar el reporte <span id="modalTitle" class="font-semibold"></span>?</p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(id, title) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('deleteForm').action = `/maintenance/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
@endsection
