@extends('layouts.dashboard')

@section('title','Historial de Aplicaciones')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('dashboard.fertilizantes') }}"
           class="text-green-700 hover:text-green-800 flex items-center transition-colors font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a Fertilizantes
        </a>
    </div>

    @if($fertilizaciones->count())
        <div class="overflow-x-auto bg-white shadow sm:rounded-lg border border-eaccent2">
            <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
                <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap">Fertilizante</th>
                        <th class="px-6 py-3 whitespace-nowrap">Producto</th>
                        <th class="px-6 py-3 whitespace-nowrap">Fecha</th>
                        <th class="px-6 py-3 whitespace-nowrap">Dosis</th>
                        <th class="px-6 py-3 whitespace-nowrap">Notas</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                    @foreach($fertilizaciones as $f)
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $f->fertilizante->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $f->producto->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($f->fecha_aplicacion)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $f->dosis_aplicada }}</td>
                            <td class="px-6 py-4 whitespace-pre-line">{{ $f->notas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 italic">No hay aplicaciones registradas todavía.</p>
    @endif
</div>
@endsection
