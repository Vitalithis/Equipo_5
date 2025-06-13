@extends('layouts.dashboard')

@section('title', 'Lista de Productos')

@section('content')
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <div class="max-w-7xl mx-auto font-['Roboto'] text-gray-800">
        <div class="rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold font-['Roboto_Condensed'] text-gray-800">Productos en Catálogo</h2>
                <a href="{{ route('catalogo.create') }}"
                   class="ml-auto flex items-center text-green-700 hover:text-green-800 border border-green-700 hover:border-green-800 px-3 py-1 rounded transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4"/>
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
                                <td class="px-4 py-2">${{ number_format($product->precio, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $product->categoria }}</td>
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
                                        <button type="button"
                                                class="text-yellow-600 hover:text-yellow-800 border border-yellow-600 hover:border-yellow-800 px-3 py-1 rounded transition-colors"
                                                onclick="openMermaModal({{ $product->id }}, '{{ $product->nombre }}')">
                                            Merma
                                        </button>
                                    </div>
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

    <!-- Modal de merma -->
    <div id="mermaModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md font-['Roboto']">
            <h2 class="text-lg font-bold text-gray-800 mb-4 font-['Roboto_Condensed']">Registrar Merma</h2>
            <p class="text-gray-700 mb-4">
                Producto: <span id="modalMermaNombre" class="font-semibold"></span>
            </p>
            <form id="mermaForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label for="cantidad_merma" class="block text-sm font-medium text-gray-700">Cantidad a descontar</label>
                    <input type="number" name="cantidad" id="cantidad_merma" min="1" required
                           class="mt-1 w-full border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="descripcion_merma" class="block text-sm font-medium text-gray-700">Motivo o descripción</label>
                    <textarea name="descripcion" id="descripcion_merma" rows="3" required
                              class="mt-1 w-full border-gray-300 rounded"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeMermaModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                        Registrar Merma
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

        function openMermaModal(id, nombre) {
            document.getElementById('modalMermaNombre').textContent = nombre;
            document.getElementById('mermaForm').action = `/dashboard/catalogo/${id}/merma`;
            document.getElementById('mermaModal').classList.remove('hidden');
            document.getElementById('mermaModal').classList.add('flex');
        }

        function closeMermaModal() {
            document.getElementById('mermaModal').classList.add('hidden');
            document.getElementById('mermaModal').classList.remove('flex');
            document.getElementById('cantidad_merma').value = '';
            document.getElementById('descripcion_merma').value = '';
        }
    </script>
@endsection
