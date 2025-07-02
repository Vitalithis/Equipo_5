@extends('layouts.home')
@section('title', $producto->nombre)
@section('content')

<div class="relative max-w-7xl mx-auto mt-12">
    <!-- Volver -->
    <a href="{{ route('products.index') }}"
       class="absolute -top-10 left-0 text-lg md:text-xl font-semibold text-blueDark hover:text-blue-600 transition">
        ← Volver a productos
    </a>

    <div class="bg-white rounded-lg p-6 pt-16">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Imagen contenida y proporcionada -->
            <div class="w-full md:w-1/2 h-[400px] flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden">
                <img src="{{ '../' . $producto->imagen }}"
                     onerror="this.onerror=null;this.src='{{ asset('storage/images/default-logo.png') }}';"
                     alt="{{ $producto->nombre }}"
                     class="object-contain h-full max-w-full">
            </div>

            <!-- Detalles del producto -->
            <div class="flex-1 flex flex-col justify-between text-blueDark">
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold">{{ $producto->nombre }}</h2>
                    <p class="italic text-sm text-gray-500">{{ $producto->nombre_cientifico }}</p>

                    <p class="text-greenPrimary text-2xl font-semibold">
                        {{ number_format($producto->precio, 0, ',', '.') }} CLP
                    </p>

                    <p class="text-sm text-gray-600">Stock disponible: {{ $producto->stock }}</p>

                    <p class="mt-2">{{ $producto->descripcion ?? 'Sin descripción' }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mt-4">
                        <p><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                        <p><strong>Dificultad:</strong> {{ $producto->nivel_dificultad }}</p>
                        <p><strong>Riego:</strong> {{ $producto->frecuencia_riego }}</p>
                        <p><strong>Ubicación ideal:</strong> {{ $producto->ubicacion_ideal }}</p>
                        <p><strong>Beneficios:</strong> {{ $producto->beneficios }}</p>
                        <p><strong>Tóxica:</strong> {{ $producto->toxica ? 'Sí' : 'No' }}</p>
                        <p><strong>Origen:</strong> {{ $producto->origen }}</p>
                        <p><strong>Tamaño máximo:</strong> {{ $producto->tamano }} cm</p>
                        <p><strong>Cuidados:</strong> {{ $producto->cuidados }}</p>
                    </div>

                    <!-- Código de barras -->
                    <div class="mt-6 text-center">
                        <p class="text-4xl font-normal tracking-widest" style="font-family: 'Libre Barcode 128 Text', cursive;">
                            {{ $producto->codigo_barras }}
                        </p>
                    </div>
                </div>

                <!-- Agregar al carrito -->
                <form method="POST" action="{{ route('cart.add', ['id' => $producto->id]) }}" class="space-y-2">
                    @csrf
                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                    <label for="cantidad" class="block text-sm font-medium">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" value="1" min="1"
                           class="w-24 px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">

                    @if($producto->stock > 0)
                        <button type="submit"
                                class="block w-full md:w-auto bg-greenPrimary text-white px-6 py-2 rounded-lg hover:bg-greenDark transition-colors">
                            Agregar al carrito
                        </button>
                    @else
                        <span
                            class="block w-full md:w-auto bg-red-600 text-white px-6 py-2 rounded-lg cursor-not-allowed text-center select-none">
                            Producto sin stock
                        </span>
                    @endif
                </form>
            </div>
        </div>

        <!-- Productos relacionados -->
        @if($relacionados->count())
            <h3 class="text-xl font-semibold text-blueDark mt-10 mb-4">Productos relacionados</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relacionados as $rel)
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <a href="{{ route('products.show', $rel->slug) }}">
                            <img src="{{ asset('storage/images/product' . $rel->imagen_principal) }}"
                                 onerror="this.onerror=null;this.src='{{ asset('storage/images/default-logo.png') }}';"
                                 class="w-full h-32 object-cover rounded mb-2">
                            <h4 class="text-blueDark font-semibold">{{ $rel->nombre }}</h4>
                            <p class="text-greenPrimary font-bold">{{ number_format($rel->precio, 0, ',', '.') }} CLP</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
