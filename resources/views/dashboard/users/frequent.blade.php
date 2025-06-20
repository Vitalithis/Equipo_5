@extends('layouts.dashboard')

@section('title', 'Clientes Frecuentes')

@section('content')
    {{-- Tipografías --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800">
        {{-- Encabezado --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h2 class="text-2xl font-['Roboto_Condensed'] text-eaccent2">Clientes con más de 5 compras</h2>
        </div>

        {{-- Tabla de clientes frecuentes --}}
        <div class="w-full overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
            <!-- Agrega esto en tu vista (si no lo tienes aún) -->
            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

            <!-- CSRF token para peticiones POST desde JS -->
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <div x-data="userModal()" x-init="init()">
                <table class="min-w-full table-auto divide-y divide-eaccent2 text-sm text-left">
                    <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">Nombre</th>
                            <th class="px-4 py-3 whitespace-nowrap">Email</th>
                            <th class="px-4 py-3 whitespace-nowrap">Cantidad de pedidos</th>
                            <th class="px-4 py-3 whitespace-nowrap">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                        @forelse($frequentClients as $user)
                            <tr>
                                <td class="px-4 py-3 font-medium whitespace-nowrap">{{ $user->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $user->pedidos_count }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button
                                        class="text-green-700 hover:text-green-900 border border-green-700 hover:border-green-900 px-3 py-1 rounded transition-colors"
                                        @click="show({ id: {{ $user->id }}, name: '{{ $user->name }}', email: '{{ $user->email }}', pedidos: '{{ $user->pedidos_count }}' })">
                                        Ver detalles
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500 italic">No hay clientes con más de 5
                                    compras aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Modal -->
                <div x-show="open" x-transition
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full space-y-4" @click.away="open = false">
                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Detalles del Cliente</h3>
                        <p><strong>Nombre:</strong> <span x-text="user.name"></span></p>
                        <p><strong>Email:</strong> <span x-text="user.email"></span></p>
                        <p><strong>Pedidos realizados:</strong> <span x-text="user.pedidos"></span></p>

                        <!-- Descuento -->
                        <form @submit.prevent="asignarDescuento()" class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Asignar descuento (%)</label>
                            <input type="number" min="0" max="100" step="1" x-model="descuento"
                                class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring focus:border-green-500"
                                placeholder="Ej: 15">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                Guardar descuento
                            </button>
                            <p x-show="successMsg" x-text="successMsg" class="text-green-600 text-sm"></p>
                        </form>

                        <div class="text-right pt-4">
                            <button @click="open = false"
                                class="px-4 py-2 bg-eaccent2 text-white rounded hover:bg-green-700">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function userModal() {
                    return {
                        open: false,
                        user: { id: null, name: '', email: '', pedidos: 0 },
                        descuento: '',
                        successMsg: '',
                        show(data) {
                            this.user = data;
                            this.descuento = '';
                            this.successMsg = '';
                            this.open = true;
                        },
                        async asignarDescuento() {
                            try {
                                const response = await fetch('/usuarios/descuento', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        user_id: this.user.id,
                                        descuento: this.descuento
                                    })
                                });

                                const result = await response.json();

                                if (response.ok) {
                                    this.successMsg = 'Descuento asignado correctamente.';
                                } else {
                                    this.successMsg = result.message || 'Ocurrió un error.';
                                }
                            } catch (error) {
                                this.successMsg = 'Error de red o servidor.';
                            }
                        },
                        init() { }
                    }
                }
            </script>

        </div>
    </div>

@endsection
