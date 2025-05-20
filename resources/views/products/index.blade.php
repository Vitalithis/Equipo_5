@extends('layouts.home')
@section('title', 'Productos || Plantas Editha')
@section('description', 'Nuestra tienda ofrece una amplia variedad de plantas de interior y exterior, ideales para cualquier espacio. Desde suculentas hasta plantas de sombra, tenemos lo que necesitas para embellecer tu hogar o jardín. Además, contamos con un equipo de expertos listos para asesorarte en el cuidado y mantenimiento de tus plantas.')
@section('content')

<!-- Banner principal -->
<div class="relative w-full h-64 md:h-96 bg-greenPrimary overflow-hidden">
    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Nuestros Productos</h1>
            <p class="text-xl md:text-2xl text-white max-w-2xl mx-auto">Descubre nuestra selección de plantas para todos los espacios y niveles de cuidado</p>
        </div>
    </div>
    <img src="{{ asset('/storage/images/banner-productos.jpg') }}" alt="Variedad de plantas" class="w-full h-full object-cover">
</div>

<!-- Contenedor principal -->
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Aside de filtros -->
        <aside class="w-full md:w-1/4 lg:w-1/5">
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                <h2 class="text-xl font-bold text-blueDark mb-6 border-b pb-2">Filtrar Productos</h2>

                <!-- Filtro por categoría -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Categorías</h3>
                    <ul class="space-y-2">
                        @foreach($categorias as $categoria)
                        <li>
                            <a href="{{ route('producto.filterByCategory', ['category' => $categoria->nombre]) }}"
                               class="flex items-center text-blueDark hover:text-greenPrimary transition-colors">
                                <span class="mr-2">•</span>
                                {{ $categoria->nombre }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Filtro por tamaño -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Tamaño máximo (cm)</h3>
                    <input type="range" id="tamano" name="tamano" min="10" max="200"
                           value="{{ $tamano ?? 200 }}"
                           class="w-full h-2 bg-greenMid rounded-lg appearance-none cursor-pointer">
                    <div class="flex justify-between text-sm text-blueDark mt-1">
                        <span>10cm</span>
                        <span id="tamanoValue">{{ $tamano ?? 200 }}cm</span>
                        <span>200cm</span>
                    </div>
                </div>

                <!-- Filtro por dificultad -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Nivel de dificultad</h3>
                    <select name="dificultad" id="dificultad" class="w-full p-2 border border-greenMid rounded-lg text-blueDark">
                        <option value="">Todos los niveles</option>
                        <option value="baja" {{ $dificultad == 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ $dificultad == 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta" {{ $dificultad == 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>

                <!-- Filtro de orden -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Ordenar por</h3>
                    <select name="filter2" id="filter2" class="w-full p-2 border border-greenMid rounded-lg text-blueDark">
                        <option value="relevancia" {{ $ordenar_por == 'relevancia' ? 'selected' : '' }}>Relevancia</option>
                        <option value="precio" {{ $ordenar_por == 'precio' ? 'selected' : '' }}>Precio</option>
                        <option value="popularidad" {{ $ordenar_por == 'popularidad' ? 'selected' : '' }}>Popularidad</option>
                    </select>
                    <div class="mt-2 flex items-center">
                        <input type="radio" id="ascendente" name="filter3" value="ascendente"
                               {{ $ordenar_ascendente ? 'checked' : '' }} class="mr-2">
                        <label for="ascendente" class="text-sm text-blueDark">Ascendente</label>
                        <input type="radio" id="descendente" name="filter3" value="descendente"
                               {{ !$ordenar_ascendente ? 'checked' : '' }} class="ml-4 mr-2">
                        <label for="descendente" class="text-sm text-blueDark">Descendente</label>
                    </div>
                </div>

                <button id="aplicarFiltros" class="w-full py-2 bg-greenPrimary text-white rounded-lg hover:bg-greenDark transition-colors">
                    Aplicar Filtros
                </button>
            </div>
        </aside>

        <!-- Sección de productos -->
        <div class="w-full md:w-3/4 lg:w-4/5">
            @if($productos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($productos as $producto)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        <a href="{{ route('products.show', $producto->slug) }}" class="block">
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $producto->imagen_principal) }}"
                                     alt="{{ $producto->nombre }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-semibold text-blueDark">{{ $producto->nombre }}</h3>
                                    <span class="text-greenPrimary font-bold">{{ number_format($producto->precio, 0, ',', '.') }} CLP</span>
                                </div>
                                <div class="flex items-center mt-2">
                                    <span class="text-sm text-blueDark bg-blueLight px-2 py-1 rounded mr-2">
                                        {{ $producto->nivel_dificultad }}
                                    </span>
                                    <span class="text-sm text-blueDark">{{ $producto->tamano }}cm</span>
                                </div>
                                <p class="text-blueDark mt-2 line-clamp-2">{{ $producto->descripcion_corta }}</p>
                                <button class="mt-4 w-full py-2 bg-greenPrimary text-white rounded-lg hover:bg-greenDark transition-colors">
                                    Ver detalles
                                </button>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-8">
                    {{ $productos->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-blueDark">No se encontraron productos</h3>
                    <p class="text-blueDark mt-2">Intenta ajustar tus filtros de búsqueda</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Actualizar valor del rango de tamaño
    document.getElementById('tamano').addEventListener('input', function() {
        document.getElementById('tamanoValue').textContent = this.value + 'cm';
    });

    // Aplicar filtros
    document.getElementById('aplicarFiltros').addEventListener('click', function() {
        const tamano = document.getElementById('tamano').value;
        const dificultad = document.getElementById('dificultad').value;
        const ordenarPor = document.getElementById('filter2').value;
        const ordenDireccion = document.querySelector('input[name="filter3"]:checked').value;

        let url = '{{ route("products.index") }}?';
        if(tamano) url += `&tamano=${tamano}`;
        if(dificultad) url += `&dificultad=${dificultad}`;
        if(ordenarPor) url += `&filter2=${ordenarPor}`;
        if(ordenDireccion) url += `&filter3=${ordenDireccion}`;

        window.location.href = url;
    });
</script>

@endsection
