<section class="w-full px-4 md:px-20 py-16 bg-blueLight">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-extrabold text-blueDark mb-10 text-center">Últimos Productos agregados</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($productos as $producto)
                <a href="{{ route('products.show', $producto->slug) }}"
                    class="group bg-white border border-greenMid rounded-xl overflow-hidden shadow hover:shadow-lg transition-shadow duration-200 flex flex-col h-full">

                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
                        <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}"
                            class="object-cover w-full h-48 group-hover:scale-105 transition-transform duration-300" />
                    </div>

                    <div class="px-4 py-2 flex flex-col justify-between flex-grow min-h-[150px]">

                        <div>
                            <div class="flex justify-between items-center">
                                <h3
                                    class="text-lg font-semibold text-blueDark group-hover:text-greenPrimary transition-colors duration-200 max-w-[65%] truncate">
                                    {{ $producto->nombre }}
                                </h3>
                                <p class="font-bold text-greenPrimary whitespace-nowrap">
                                    ${{ number_format($producto->precio, 0, ',', '.') }}
                                </p>
                            </div>

                            <p class="text-sm text-blueDark mt-1 line-clamp-3">
                                {{ Str::limit($producto->descripcion, 60) }}
                            </p>
                        </div>
                        <button
                            class=" w-full py-2 bg-greenPrimary text-white rounded-lg hover:bg-greenDark transition-colors"
                            type="button" onclick="window.location='{{ route('products.show', $producto->slug) }}'">
                            Ver detalles
                        </button>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
</section>
