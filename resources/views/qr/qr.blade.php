<!-- resources/views/qr/care.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cuidados de {{ $producto->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">

    <div class="bg-white p-6 rounded shadow-md w-full max-w-md text-center">
        <h1 class="text-2xl font-bold mb-6">Cuidados de la planta: {{ $producto->nombre }}</h1>

        <p class="text-lg text-gray-700 mb-4">Aquí están los cuidados recomendados:</p>

        <div class="text-left">
            <p class="mb-4"><strong>Instrucciones:</strong></p>
            <p>{{ $producto->cuidados }}</p>
        </div>

        <p class="mt-4 text-gray-700"><strong>Frecuencia de riego:</strong> {{ $producto->frecuencia_riego }}</p>
        <p class="mt-4 text-gray-700"><strong>Ubicación ideal:</strong> {{ $producto->ubicacion_ideal }}</p>
        <p class="mt-4 text-gray-700"><strong>Beneficios:</strong> {{ $producto->beneficios }}</p>
    </div>

</body>
</html>
