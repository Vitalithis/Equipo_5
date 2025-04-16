@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gray-100">
        <div class="w-full h-[70vh] overflow-hidden">
            <div class="flex h-full">
                <!-- Slider Position 1 -->
                <div class="w-full flex-shrink-0 bg-gray-200 flex items-center justify-center">
                    <h1 class="text-4xl font-bold">Slider Position 1</h1>
                </div>
                <!-- Slider Position 2 -->
                <div class="w-full flex-shrink-0 bg-gray-300 flex items-center justify-center">
                    <h1 class="text-4xl font-bold">Slider Position 2</h1>
                </div>
                <!-- Slider Position 3 -->
                <div class="w-full flex-shrink-0 bg-gray-400 flex items-center justify-center">
                    <h1 class="text-4xl font-bold">Slider Position 3</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="container mx-auto py-8">
        <div class="grid grid-cols-4 gap-4">
            <!-- Sidebar for Filters -->
            <aside class="col-span-1 bg-eaccent2-100 p-4 rounded sticky top-4 self-start">
                <h2 class="text-xl font-semibold mb-4">Filtrar Plantas</h2>

                <div class="">
                    <button onclick="toggleAccordion(1)"
                        class="w-full flex justify-between items-center py-5 text-slate-800">

                        <div class="icon flex items-center gap-2">
                            {!! \App\Helpers\SvgHelper::inline('tall-fill', 'fill-eaccent2-9') !!}
                            <span>Tamaño</span>
                        </div>

                        <span id="icon-1" class="text-slate-800 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                <path
                                    d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                            </svg>
                        </span>
                    </button>

                    <div id="content-1"
                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-eaccent2-800">
                        <div class="w-full max-w-md px-4 text-sm text-efore border-b-4 border-green- rounded-sm py-2">
                            <label for="rango" class="block mb-2 text-sm font-medium text-gray-700">
                                Hasta <span id="valorSeleccionado" class="text-sm font-medium text-gray-800">50</span>
                                metros.
                            </label>

                            <div class="flex items-center gap-4">
                                <input type="range" id="rango" name="rango" min="1" max="100" value="50"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-eaccent2-600"
                                    oninput="document.getElementById('valorSeleccionado').textContent = this.value">


                            </div>

                            <div class="flex justify-between text-sm text-gray-600 mt-1 pxr-2">
                                <span>1</span>
                                <span>100</span>
                            </div>
                        </div>

                    </div>
                    <button onclick="toggleAccordion(2)"
                        class="w-full flex justify-between items-center py-5 text-slate-800">

                        <div class="icon flex items-center gap-2">
                            {!! \App\Helpers\SvgHelper::inline('potted-plant-fill', 'fill-eaccent2-9') !!}
                            <span>Categoría</span>
                        </div>

                        <span id="icon-1" class="text-slate-800 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                <path
                                    d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                            </svg>
                        </span>
                    </button>

                    <div id="content-2"
                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-eaccent2-800 ">
                        <div class="text-sm text-efore border-b-4 border-green- rounded-sm">
                            <ul class="px-4 py-2">
                                @foreach($categorias as $categoria)
                                    <li class="flex items-center gap-2 text-base py-1">
                                        <input id="filter-color-2" name="{{ $categoria->nombre }}" value="eprimary"
                                            type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm
                                                                                border border-gray-300 bg-white
                                                                            checked:border-eprimary-100 checked:bg-eprimary-100
                                                                            indeterminate:border-eprimary-100 indeterminate:bg-eprimary-100
                                                                            focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-eprimary-100
                                                                            focus:ring-2 focus:ring-eprimary-100
                                                                            disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100
                                                                            forced-colors:appearance-auto">

                                        <span>{{ $categoria->nombre }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button onclick="toggleAccordion(3)"
                        class="w-full flex justify-between items-center py-5 text-slate-800">

                        <div class="icon flex items-center gap-2">
                            {!! \App\Helpers\SvgHelper::inline('brain-fill', 'fill-eaccent2-9') !!}
                            <span>Dificultad</span>
                        </div>

                        <span id="icon-1" class="text-slate-800 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                <path
                                    d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                            </svg>
                        </span>
                    </button>

                    <div id="content-3"
                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-eaccent2-800 ">
                        <div class="text-sm text-efore border-b-4 border-green- rounded-sm">
                            <ul class="px-4 py-2">
                                @foreach($productos->unique('nivel_dificultad') as $producto)
                                    <li class="flex items-center gap-2 text-base py-1">
                                        <p class="text-efore">
                                            <input class="rounded-sm" type="checkbox" name="{{ $producto->nivel_dificultad }}"
                                                id="">
                                            {{ $producto->nivel_dificultad }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="filter2">
                        <div class="icon flex items-center gap-2">
                            {!! \App\Helpers\SvgHelper::inline('funnel-simple-fill', 'fill-eaccent2-9') !!}
                            <span>Ordenar por:</span>
                        </div>
                        <select id="filter2" name="filter2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-eaccent2-100 focus:ring focus:ring-eaccent2-100">
                            <option value="relevancia">Relevancia</option>
                            <option value="precio">Precio</option>
                            <option value="popularidad">Popularidad</option>
                        </select>
                    </label>
                </div>
                <div class="mb-4">
                    <label for="filter3">
                        <button onclick="toggleSortIcon(this)" type="button" class="flex items-center gap-2">
                            <span class="icon">
                                {!! \App\Helpers\SvgHelper::inline('sort-ascending-fill', 'fill-eaccent2-9') !!}
                            </span>
                            <span class="text-sm text-gray-700">Ordenar Ascendente</span>
                        </button>
                    </label>
                </div>

            </aside>

            <!-- Product Catalog -->
            <div class="col-span-3 bg-gray-50 p-4 rounded">
                <h2 class="text-xl font-semibold mb-4">Catálogo de Productos</h2>
                <div class="grid grid-cols-3 gap-4">

                    @foreach ( $productos as $producto )
                    <div class="bg-white p-4 shadow rounded">
                        <!----
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{$producto->nombre}}"
                            class="w-full h-32 object-cover mb-4 rounded">---->
                        <img src="{{ $producto->imagen}}" alt="{{$producto->nombre}}" class="w-full h-32 object-cover mb-4 rounded">
                        <h3 class="font-bold">{{$producto->nombre}}</h3>
                        <p class="text-sm text-gray-600">{{$producto->dificultad}}</p>
                        <p class="text-sm text-gray-600">{{$producto->descripcion}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleAccordion(index) {
            const content = document.getElementById(`content-${index}`);
            const icon = document.getElementById(`icon-${index}`);

            // SVG for Minus icon
            const minusSVG = `
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                                                        <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
                                                                    </svg>
                                                                    `;

            // SVG for Plus icon
            const plusSVG = `
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                                                        <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                                                    </svg>
                                                                    `;

            // Toggle the content's max-height for smooth opening and closing
            if (content.style.maxHeight && content.style.maxHeight !== '0px') {
                content.style.maxHeight = '0';
                icon.innerHTML = plusSVG;
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.innerHTML = minusSVG;
            }
        }

        function toggleSortIcon(button) {
            const iconSpan = button.querySelector('.icon');
            const textSpan = button.querySelector('span.text-sm');

            const ascIcon = `{!! \App\Helpers\SvgHelper::inline('sort-ascending-fill', 'fill-eaccent2-9') !!}`;
            const descIcon = `{!! \App\Helpers\SvgHelper::inline('sort-descending-fill', 'fill-eaccent2-9') !!}`;

            const isAscending = iconSpan.innerHTML.includes('sort-ascending-fill');

            iconSpan.innerHTML = isAscending ? descIcon : ascIcon;
            textSpan.textContent = isAscending ? 'Ordenar Descendente' : 'Ordenar Ascendente';
        }
    </script>
@endsection
