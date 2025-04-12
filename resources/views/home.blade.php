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
            <aside class="col-span-1 bg-eaccent2-100 p-4 rounded">
                <h2 class="text-xl font-semibold mb-4">Filtrar Plantas</h2>

                <div class="border-b border-slate-200 mb-4">
                    <button onclick="toggleAccordion(1)"
                        class="w-full flex justify-between items-center py-5 text-slate-800">
                        <span>
                            <div class='icon'>{!! \App\Helpers\SvgHelper::inline('tall-fill','fill-eaccent2-900') !!}Tamaño</div>
                            </span>
                        <span id="icon-1" class="text-slate-800 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                <path
                                    d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                            </svg>
                        </span>
                    </button>
                    <div id="content-1" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                        <div class="pb-5 text-sm text-slate-500">
                            Material Tailwind is a framework that enhances Tailwind CSS with additional styles and components.
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <input type="checkbox" id="filter2" class="mr-2">
                    <label for="filter2">Filtro 2</label>
                </div>

                <div class="mb-4">
                    <input type="checkbox" id="filter3" class="mr-2">
                    <label for="filter3">Filtro 3</label>
                </div>
            </aside>

            <!-- Product Catalog -->
            <div class="col-span-3 bg-gray-50 p-4 rounded">
                <h2 class="text-xl font-semibold mb-4">Catálogo de Productos</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white p-4 shadow rounded">
                        <h3 class="font-bold">Producto 1</h3>
                        <p class="text-sm text-gray-600">Descripción breve del producto.</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded">
                        <h3 class="font-bold">Producto 2</h3>
                        <p class="text-sm text-gray-600">Descripción breve del producto.</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded">
                        <h3 class="font-bold">Producto 3</h3>
                        <p class="text-sm text-gray-600">Descripción breve del producto.</p>
                    </div>
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
    </script>
@endsection
