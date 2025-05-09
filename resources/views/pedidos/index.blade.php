@extends('dashboard')

@section('title', 'Gestión de Pedidos')

@section('default-content')
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-8 py-10 bg-efore rounded-xl shadow-lg">
    <h1 class="text-4xl font-extrabold text-eprimary mb-8 text-center">Gestión de Pedidos</h1>

    @if (session('success'))
        <div class="bg-[#FFF9DB] border-l-4 border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if ($pedidos->count())
        <div class="overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
            <table class="min-w-full divide-y divide-eaccent2 text-sm">
                <thead class="bg-eaccent2 text-eprimary uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-6 py-4 text-center">ID</th>
                        <th class="px-6 py-4 text-center">Usuario</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-efore">
                    @foreach ($pedidos as $pedido)
                        <tr class="hover:bg-efore transition duration-200 cursor-pointer" onclick="toggleDetalles({{ $pedido->id }})">
                            <td class="px-6 py-4 text-center font-bold text-eprimary">{{ $pedido->id }}</td>
                            <td class="px-6 py-4 text-center text-gray-900">{{ $pedido->usuario->name }}</td>
                            <td class="px-6 py-4 text-center text-gray-900">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center text-gray-900">
                                @include('pedidos.estado_form', ['pedido' => $pedido])
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span id="icon-{{ $pedido->id }}" class="inline-block">
                                    <!-- SVG inicial: plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary">
                                        <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                    </svg>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="p-0">
                                <div id="detalles-{{ $pedido->id }}"
                                    class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary">
                                    <div class="p-6 space-y-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <p><strong class="text-eprimary">Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
                                            <p><strong class="text-eprimary">Dirección:</strong> {{ $pedido->direccion ?? 'No disponible' }}</p>
                                            <p><strong class="text-eprimary">Fecha de pedido:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
                                        </div>

                                        <div>
                                            <p class="font-semibold text-eprimary mb-2">Productos:</p>
                                            <ul class="list-disc list-inside ml-4 space-y-1">
                                                @foreach ($pedido->detalles as $detalle)
                                                    <li>
                                                        <span class="text-gray-800">{{ $detalle->nombre_producto_snapshot }}</span>
                                                        <span class="text-gray-600">(x{{ $detalle->cantidad }},
                                                        ${{ number_format($detalle->precio_unitario, 0, ',', '.') }},
                                                        Subtotal: ${{ number_format($detalle->subtotal, 0, ',', '.') }})</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-4">
                                            <div class="flex items-center gap-2">
                                                <strong class="text-eprimary">Boleta SII:</strong>
                                                @if($pedido->boleta_final_path)
                                                    <span class="text-green-600 font-medium">Subida</span>
                                                    <button class="open-modal-pdf text-esecondary hover:text-eaccent text-sm underline"
                                                            data-pdf="{{ asset('storage/' . $pedido->boleta_final_path) }}">
                                                        Ver PDF
                                                    </button>
                                                @else
                                                    <span class="text-red-500 font-medium">No subida</span>
                                                @endif

                                                <button class="open-modal-upload text-eaccent hover:text-eaccent2 text-lg"
                                                        data-action="{{ route('boletas.subir', ['pedido' => $pedido->id]) }}">
                                                    📤
                                                </button>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <button class="open-modal-provisoria inline-block bg-yellow-100 hover:bg-yellow-200 text-eprimary font-semibold text-sm px-4 py-2 rounded shadow transition"
                                                    data-url="{{ route('boletas.provisoria', $pedido->id) }}">
                                                    Ver boleta provisoria
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-lg text-gray-600 mt-10">No hay pedidos registrados.</p>
    @endif
</div>


{{-- Modal Provisoria --}}
<div id="provisoria-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl w-full relative">
        <button id="provisoria-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <iframe src="" class="w-full h-96 rounded border" id="provisoria-iframe"></iframe>
    </div>
</div>


{{-- Modal PDF --}}
<div id="pdf-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl w-full relative">
        <button id="pdf-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <div id="pdf-modal-content" class="p-4"></div>
    </div>
</div>

{{-- Modal Upload --}}
<div id="upload-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-md w-full relative">
        <button id="upload-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <h2 class="text-lg font-bold mb-4 text-eprimary">Subir Boleta SII</h2>
        <form id="upload-form" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="boleta" accept="application/pdf" required class="w-full border rounded px-3 py-2">
            <button type="submit"
                class="bg-eaccent hover:bg-eaccent2 text-eprimary font-semibold px-4 py-2 rounded shadow transition w-full">
                Subir Boleta
            </button>
        </form>
    </div>
</div>

{{-- JS --}}
<script>
function toggleDetalles(id) {
    const detalles = document.getElementById('detalles-' + id);
    const iconSpan = document.getElementById('icon-' + id);
    const isOpen = detalles.classList.contains('max-h-[500px]');

    const minusSVG = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary"><path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" /></svg>`;
    const plusSVG = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary"><path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" /></svg>`;

    if (isOpen) {
        detalles.classList.remove('max-h-[500px]', 'opacity-100');
        detalles.classList.add('max-h-0', 'opacity-0');
        iconSpan.innerHTML = plusSVG;
    } else {
        detalles.classList.remove('max-h-0', 'opacity-0');
        detalles.classList.add('max-h-[500px]', 'opacity-100');
        iconSpan.innerHTML = minusSVG;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const pdfModal = document.getElementById('pdf-modal');
    const pdfContent = document.getElementById('pdf-modal-content');
    const pdfClose = document.getElementById('pdf-modal-close');

    document.querySelectorAll('.open-modal-pdf').forEach(btn => {
        btn.addEventListener('click', () => {
            const pdfUrl = btn.getAttribute('data-pdf');
            pdfContent.innerHTML = `<iframe src="${pdfUrl}" class="w-full h-96 rounded border"></iframe>`;
            pdfModal.classList.remove('hidden');
        });
    });

    pdfClose.addEventListener('click', () => {
        pdfModal.classList.add('hidden');
        pdfContent.innerHTML = '';
    });

    const uploadModal = document.getElementById('upload-modal');
    const uploadForm = document.getElementById('upload-form');
    const uploadClose = document.getElementById('upload-modal-close');

    document.querySelectorAll('.open-modal-upload').forEach(btn => {
        btn.addEventListener('click', () => {
            const actionUrl = btn.getAttribute('data-action');
            uploadForm.action = actionUrl;
            uploadModal.classList.remove('hidden');
        });
    });

    uploadClose.addEventListener('click', () => {
        uploadModal.classList.add('hidden');
        uploadForm.reset();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const provisoriaModal = document.getElementById('provisoria-modal');
    const provisoriaIframe = document.getElementById('provisoria-iframe');
    const provisoriaClose = document.getElementById('provisoria-modal-close');

    document.querySelectorAll('.open-modal-provisoria').forEach(btn => {
        btn.addEventListener('click', () => {
            const provisoriaUrl = btn.getAttribute('data-url');
            provisoriaIframe.src = provisoriaUrl;
            provisoriaModal.classList.remove('hidden');
        });
    });

    provisoriaClose.addEventListener('click', () => {
        provisoriaModal.classList.add('hidden');
        provisoriaIframe.src = '';
    });
});


</script>

@endsection
