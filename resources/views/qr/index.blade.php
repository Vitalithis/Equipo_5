<!-- resources/views/qr/index.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Generar QR para Cuidados de Plantas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">

    <div class="bg-white p-6 rounded shadow-md w-full max-w-md text-center">
        <h1 class="text-2xl font-bold mb-6">Generar QR para Cuidados de Plantas</h1>

        <!-- Aquí deberías tener la lista de plantas (puedes obtenerlas de la base de datos) -->
        @foreach($productos as $producto)
            <div class="mb-4">
                <form action="{{ route('generar.qr', $producto->id) }}" method="GET">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                        Generar QR para {{ $producto->nombre }}
                    </button>
                </form>
            </div>
        @endforeach

        @isset($qr)
            <div class="mt-6">
                {!! $qr !!}
                <p class="mt-4 text-gray-700">Escanea este código QR para ver los cuidados de la planta {{ $producto->nombre }}</p>
            </div>
        @endisset
    </div>

</body>
</html>
