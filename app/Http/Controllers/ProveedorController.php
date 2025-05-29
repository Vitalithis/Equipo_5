<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::latest()->get();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $valores_permitidos = ['Sustratos', 'Productos aplicables', 'Herramientas', 'Servicios Vivero', 'Construccion', 'Plantas', 'Arboles', 'Plasticos/Cerámicas', 'Plantines'];
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string',
            'empresa' => 'nullable|string|max:255',
            'tipo_proveedor' => ['nullable', 'string', Rule::in($valores_permitidos)],
            'estado' => 'required|in:Activo,Inactivo',
            'notas' => 'nullable|string',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

public function edit(Proveedor $proveedor)
{
    return view('proveedores.edit', compact('proveedor'));
}


    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string',
            'empresa' => 'nullable|string|max:255',
            'tipo_proveedor' => 'nullable|string|max:100',
            'estado' => 'required|in:Activo,Inactivo',
            'notas' => 'nullable|string',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
