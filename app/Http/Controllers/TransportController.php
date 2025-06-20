<?php

namespace App\Http\Controllers;

use App\Models\GastoTransporte;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index(Request $request)
    {
        $query = GastoTransporte::query();



        if ($request->filled('transportista')) {
            $query->where('transportista_nombre', 'like', '%'.$request->transportista.'%');
        }

        if ($request->filled('tipo_gasto')) {
            $query->where('tipo_gasto', $request->tipo_gasto);
        }

        $gastos = GastoTransporte::query()
            ->when($request->filled('transportista'), fn($q) => $q->where('transportista_nombre', 'like', '%' . $request->transportista . '%'))
            ->when($request->filled('tipo_gasto'), fn($q) => $q->where('tipo_gasto', $request->tipo_gasto))
            ->latest()
            ->paginate(10); // <<— Aquí está la clave
        return view('dashboard.transports.transports', compact('gastos'));
    }


    public function create()
    {
        return view('dashboard.transports.create');
    }

   public function store(Request $request)
    {
        $data = $request->validate([
            'fecha' => 'required|date',
            'tipo_gasto' => 'required|in:movilizacion,reparto,retiro,flete',
            'transportista_nombre' => 'required|string|max:255',
            'transportista_contacto' => 'required|string|max:255',
            'vehiculo_descripcion' => 'nullable|string|max:255',
            'monto' => 'required|numeric|min:0',
            'detalle' => 'nullable|string',
            'comprobante_path' => 'nullable|file',
            'pagado' => 'nullable',
        ]);

        if ($request->hasFile('comprobante_path')) {
            $data['comprobante_path'] = $request->file('comprobante_path')->store('comprobantes', 'public');
        }

        $data['pagado'] = $request->boolean('pagado');  // <-- aquí el truco limpio

        GastoTransporte::create($data);

        return redirect()->route('dashboard.transports.index')->with('success', 'Gasto registrado correctamente.');
    }
    public function destroy(GastoTransporte $transport)
    {
        $transport->delete();

        return redirect()->route('dashboard.transports.index')->with('success', 'Gasto de transporte eliminado correctamente.');
    }



    public function edit(GastoTransporte $transport)
    {
        return view('dashboard.transports.edit', ['gasto' => $transport]);
    }


    public function update(Request $request, GastoTransporte $transport)
    {
        $data = $request->validate([
            'fecha' => 'required|date',
            'tipo_gasto' => 'required|in:movilizacion,reparto,retiro,flete',
            'transportista_nombre' => 'required|string|max:255',
            'transportista_contacto' => 'required|string|max:255',
            'vehiculo_descripcion' => 'nullable|string|max:255',
            'monto' => 'required|numeric|min:0',
            'detalle' => 'nullable|string',
            'comprobante_path' => 'nullable|file',
            'pagado' => 'nullable',
        ]);

        if ($request->hasFile('comprobante_path')) {
            $data['comprobante_path'] = $request->file('comprobante_path')->store('comprobantes', 'public');
        }

        $data['pagado'] = $request->boolean('pagado');

        $transport->update($data);

        return redirect()->route('dashboard.transports.index')->with('success', 'Gasto de transporte actualizado correctamente.');
    }

}
