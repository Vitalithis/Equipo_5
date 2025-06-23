@extends('layouts.dashboard')

@section('title', 'Lista de Productos')

@section('content')
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap"
        rel="stylesheet">

    <div class="max-w-7xl mx-auto font-['Roboto'] text-gray-800">
        <div class="rounded-lg shadow-sm p-6">

            <div class="mb-4 flex items-center justify-between">
                <form method="GET" action="{{ route('dashboard.catalogo') }}" class="flex space-x-4 items-center">
                    <input type="text" name="busqueda" value="{{ request('busqueda') }}" placeholder="Buscar por nombre"
                        class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-green-500" />

                    <select name="categoria" class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-green-500"">
                        <option value="">Todas las categorías</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ request('categoria') == $cat->nombre ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                        Filtrar
                    </button>
                </form>

                <a href="{{ route('catalogo.create') }}"
                    class="ml-auto flex items-center text-green-700 hover:text-green-800 border border-green-700 hover:border-green-800 px-3 py-1 rounded transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    Añadir Producto
                </a>
            </div>

            <div class="overflow-x-auto rounded-xl border border-eaccent2">
                <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
                    <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                        <tr>
                            <th class="px-6 py-4 text-center">ID</th>
                            <th class="px-6 py-4 text-left">Imagen</th>
                            <th class="px-6 py-4 text-left">Nombre</th>
                            <th class="px-6 py-4 text-left">Precio</th>
                            <th class="px-6 py-4 text-left">Categoría</th>
                            <th class="px-6 py-4 text-left">Activo</th>
                            <th class="px-6 py-4 text-left">Stock</th>
                            <th class="px-6 py-4 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-eaccent2 font-['Roboto']">
                        @foreach ($productos as $product)
                            <tr>
                                <td class="px-4 py-2 text-center">{{ $product->id }}</td>
                                <td class="px-4 py-2">
                                    <img src="{{ asset($product->imagen) }}" alt="{{ $product->nombre }}"
                                        class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="px-4 py-2">{{ $product->nombre }}</td>
                                <td class="px-4 py-2">{{ $product->precio }}</td>
                                <td class="px-4 py-2">{{ $product->categoria_id }}</td>
                                <td class="px-4 py-2">{{ $product->activo ? 'Sí' : 'No' }}</td>
                                <td class="px-4 py-2">{{ $product->stock }}</td>
                                <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-2 mt-2">
                                <a href="{{ route('catalogo_edit', ['id' => $product->id]) }}"
                                class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                    Editar
                                </a>
                                <button type="button"
                                        class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors"
                                        onclick="openDeleteModal({{ $product->id }}, '{{ $product->nombre }}', '{{ $product->categoria }}')">
                                    Eliminar
                                </button>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $productos->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
            <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">¿Eliminar producto?</h2>
            <p class="text-gray-700 mb-4">
                ¿Estás seguro que deseas eliminar el producto <span id="modalProductName" class="font-semibold"></span>
                de la categoría <span id="modalProductCategory" class="font-semibold"></span>?
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
        function openDeleteModal(id, nombre, categoria) {
            document.getElementById('modalProductName').textContent = nombre;
            document.getElementById('modalProductCategory').textContent = categoria;
            document.getElementById('deleteForm').action = `/dashboard/catalogo/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
    </script>
@endsection
