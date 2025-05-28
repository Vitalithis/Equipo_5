@extends('layouts.dashboard')

@section('title', isset($insumo->id) ? 'Editar Insumo' : 'Nuevo Insumo')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto font-['Roboto'] text-gray-800">
    <a href="{{ route('dashboard.insumos') }}"
       class="flex items-center text-green-700 hover:text-green-800 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
        Volver a la lista
    </a>

    <form action="{{ isset($insumo->id) ? route('insumos.update', $insumo->id) : route('insumos.store') }}"
          method="POST" @submit.prevent="validarFormulario" x-data="insumoForm()">
        @csrf
        @if(isset($insumo->id)) @method('PUT') @endif

        {{-- Información básica --}}
        <div class="bg-white p-6 rounded-lg shadow space-y-4">
            <h2 class="text-xl font-['Roboto_Condensed'] text-gray-900">Información del Insumo</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                           value="{{ old('nombre', $insumo->nombre ?? '') }}"
                           class="mt-1 block w-full border rounded px-3 py-2"
                           required>
                </div>

                <div>
                    <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad Total</label>
                    <input type="number" name="cantidad" id="cantidad" min="0" x-model.number="cantidadTotal"
                           value="{{ old('cantidad', $insumo->cantidad ?? 0) }}"
                           class="mt-1 block w-full border rounded px-3 py-2"
                           required>
                </div>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="mt-1 block w-full border rounded px-3 py-2">{{ old('descripcion', $insumo->descripcion ?? '') }}</textarea>
            </div>
        </div>

        {{-- Subdetalles --}}
        <div class="bg-white p-6 rounded-lg shadow mt-6 space-y-4">
            <h2 class="text-xl font-['Roboto_Condensed'] text-gray-900">Subdetalles del Insumo (opcional)</h2>

            <template x-for="(detalle, index) in detalles" :key="index">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border p-4 rounded-md">
                    <div>
                        <label class="text-sm">Nombre</label>
                        <input type="text" :name="'detalles['+index+'][nombre]'" x-model="detalle.nombre"
                               class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label class="text-sm">Cantidad</label>
                        <input type="number" :name="'detalles['+index+'][cantidad]'" x-model.number="detalle.cantidad"
                               @input="recalcularCantidad()" min="0" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label class="text-sm">Costo</label>
                        <input type="number" :name="'detalles['+index+'][costo]'" x-model.number="detalle.costo"
                               min="0" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div class="flex items-end">
                        <button type="button" @click="eliminarDetalle(index)"
                                class="w-full px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                            Eliminar
                        </button>
                    </div>
                </div>
            </template>

            <button type="button" @click="detalles.push({ nombre: '', cantidad: 0, costo: 0 })"
                class="inline-flex items-center text-sm text-green-600 hover:underline">
                + Añadir subdetalle
            </button>

            <template x-if="mensajeError">
                <p class="text-red-600 text-sm" x-text="mensajeError"></p>
            </template>
        </div>

        {{-- Botones --}}
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('dashboard.insumos') }}"
               class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                {{ isset($insumo->id) ? 'Actualizar' : 'Guardar' }} Insumo
            </button>
        </div>
    </form>
</div>

<script>
function insumoForm() {
    return {
        cantidadTotal: {{ old('cantidad', $insumo->cantidad ?? 0) }},
        detalles: [],
        mensajeError: '',

        eliminarDetalle(index) {
            this.detalles.splice(index, 1);
            this.recalcularCantidad();
        },

        recalcularCantidad() {
            const suma = this.detalles.reduce((acc, d) => acc + (parseInt(d.cantidad) || 0), 0);
            if (suma > this.cantidadTotal) {
                this.mensajeError = 'La suma de subcantidades no puede superar la cantidad total.';
            } else {
                this.mensajeError = '';
            }
        },

        validarFormulario() {
            if (this.mensajeError) return;

            for (const d of this.detalles) {
                if (!d.nombre || d.cantidad <= 0 || d.costo < 0) {
                    this.mensajeError = 'Completa todos los campos en los subdetalles o elimínalos si no los usarás.';
                    return;
                }
            }

            $el.closest('form').submit();
        }
    };
}
</script>
@endsection
