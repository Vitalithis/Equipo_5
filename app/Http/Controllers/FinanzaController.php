<?php

namespace App\Http\Controllers;

use App\Models\Finanza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanzaController extends Controller
{
    public function index(Request $request)
    {
        $query = Finanza::query()->with('usuario');

        // Filtro por fechas
        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        $finanzas = $query->latest()->get();

        $totalIngresos = $finanzas->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos = $finanzas->where('tipo', 'egreso')->sum('monto');
        $balance = $totalIngresos - $totalEgresos;

        return view('dashboard.finance.finanzas', compact('finanzas', 'totalIngresos', 'totalEgresos', 'balance'));
    }

    public function create()
    {
        return view('dashboard.finance.finanzas_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'categoria' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $finanza = new Finanza();
        $finanza->tipo = $request->input('tipo');
        $finanza->monto = $request->input('monto');
        $finanza->fecha = $request->input('fecha');
        $finanza->categoria = $request->input('categoria');
        $finanza->descripcion = $request->input('descripcion');
        $finanza->created_by = Auth::id();
        $finanza->save();

        return redirect()->route('dashboard.finanzas')->with('success', 'Registro financiero creado exitosamente.');
    }

    public function edit($id)
    {
        $finanza = Finanza::findOrFail($id);
        return view('dashboard.finance.finanzas_edit', compact('finanza'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'categoria' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $finanza = Finanza::findOrFail($id);
        $finanza->tipo = $request->input('tipo');
        $finanza->monto = $request->input('monto');
        $finanza->fecha = $request->input('fecha');
        $finanza->categoria = $request->input('categoria');
        $finanza->descripcion = $request->input('descripcion');
        $finanza->save();

        return redirect()->route('dashboard.finanzas')->with('success', 'Registro financiero actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $finanza = Finanza::findOrFail($id);
        $finanza->delete();

        return redirect()->route('dashboard.finanzas')->with('success', 'Registro financiero eliminado exitosamente.');
    }
}
