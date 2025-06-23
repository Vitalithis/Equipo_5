<form action="{{ route('pedidos.actualizarEstado', $pedido->id) }}" method="POST" class="flex items-center gap-2" onclick="event.stopPropagation();">
    @csrf
    @method('PUT')

    @php 
        $estadosTraducidos = \App\Models\Pedido::estadosTraducidos();
        $estadosPermitidos = $pedido->estadosPermitidos();
    @endphp

    @php
    $pref = Auth::user()?->preference;
@endphp

    <select name="estado_pedido" class="rounded border px-2 py-1 text-sm bg-white text-eprimary focus:ring-2 focus:ring-eaccent2-500">
        @foreach ($estadosPermitidos as $valor)
            <option value="{{ $valor }}" {{ $pedido->estado_pedido === $valor ? 'selected' : '' }}>
                {{ $estadosTraducidos[$valor] }}
            </option>
        @endforeach
    </select>

    <button type="submit"
            class="bg-eaccent2 hover:bg-eaccent2-400 text-eprimary font-semibold px-3 py-1 rounded shadow transition text-sm">
        Guardar
    </button>
</form>
