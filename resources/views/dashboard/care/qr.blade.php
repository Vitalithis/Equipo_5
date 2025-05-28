@extends('layouts.dashboard')

@section('title', 'Código QR para ' . $cuidado->producto->nombre)

@section('content')
<div class="flex items-center mb-6">
        <a href="{{ route('dashboard.cuidados') }}" class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
        
</div>

<div class="p-10 bg-white max-w-xl mx-auto rounded-xl shadow-xl border-4 border-green-600 flex flex-col items-center min-h-[70vh]">

    

    {{-- Contenedor que se descarga/imprime --}}
    <div id="printable-area" class="flex flex-col items-center w-full">

        {{-- Nombre Planta --}}
        <h1 class="text-5xl font-extrabold mb-10  font-['Roboto_Condensed'] text-center drop-shadow-md">
            {{ $cuidado->producto->nombre }}
        </h1>

        {{-- Contenedor QR --}}
        <div id="qr-container" class="w-72 h-72 mb-8 flex items-center justify-center bg-white rounded-lg shadow-inner">
            {!! $qr !!}
        </div>

        {{-- Texto explicativo --}}
        <p class="text-xl text-gray-700 text-center max-w-md font-medium leading-relaxed px-6">
            Escanea el código QR para abrir el PDF con los cuidados esenciales de esta planta.
        </p>

    </div>

    {{-- Botón descarga --}}
    <button id="download-btn" type="button"
        class="group relative mt-8 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -ml-1" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
        </svg>
        Descargar imagen
    </button>
</div>

{{-- html2canvas --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.getElementById('download-btn').addEventListener('click', function() {
    const printableArea = document.getElementById('printable-area');
    html2canvas(printableArea, {backgroundColor: null, scale: 2}).then(canvas => {
        const link = document.createElement('a');
        link.download = '{{ $cuidado->producto->nombre }}_qr_cuidados.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
});
</script>
@endsection
