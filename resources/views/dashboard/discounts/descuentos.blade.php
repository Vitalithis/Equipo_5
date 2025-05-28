@extends('layouts.dashboard')

@section('title','Listado de descuentos')

@section('content')
    {{-- Tipografías --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
        <div class="flex items-center mb-6">
            <a href="{{ route('descuentos.create') }}"
               class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Agregar Descuento
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
            <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
                <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap">Nombre</th>
                        <th class="px-6 py-3 whitespace-nowrap">Porcentaje</th>
                        <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                    @foreach($descuentos as $descuento)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $descuento->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $descuento->porcentaje }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('descuentos_edit', ['id' => $descuento->id]) }}"
                                   class="text-blue-600 hover:text-blue-900">Editar</a>
                                <form action="{{ route('descuentos.destroy', $descuento->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
