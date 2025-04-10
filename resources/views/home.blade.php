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
            <aside class="col-span-1 bg-eaccent2 p-4 rounded">
                <h2 class="text-xl font-semibold mb-4">Filtrar Plantas</h2>
                <ul class="space-y-2">
                    <li><input type="checkbox" id="filter1" class="mr-2"><label for="filter1">Filtro 1</label></li>
                    <li><input type="checkbox" id="filter2" class="mr-2"><label for="filter2">Filtro 2</label></li>
                    <li><input type="checkbox" id="filter3" class="mr-2"><label for="filter3">Filtro 3</label></li>
                </ul>
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
@endsection
