<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    // Listar tenants
    public function index()
    {
        $tenants = Tenant::with('domains')->get();
        return view('tenants.index', compact('tenants'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('tenants.create');
    }

    // Guardar nuevo tenant
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:tenants,id',
            'nombre' => 'required|string',
            'activo' => 'nullable|boolean',
            'domain' => 'required|string|unique:domains,domain',
        ]);

        $tenant = Tenant::create([
            'id' => Str::slug($request->id),
            'data' => [
                'nombre' => $request->nombre,
                'activo' => $request->activo ?? false,
            ],
        ]);

        $tenant->domains()->create([
            'domain' => $request->domain,
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant creado correctamente.');
    }

    // Mostrar detalles tenant
    public function show($id)
    {
        $tenant = Tenant::with('domains')->findOrFail($id);
        return view('tenants.show', compact('tenant'));
    }

    // Alternar estado activo
    public function toggleActivo($id)
    {
        $tenant = Tenant::findOrFail($id);
        $data = $tenant->data ?? [];
        $data['activo'] = !($data['activo'] ?? false);
        $tenant->update(['data' => $data]);

        return redirect()->route('tenants.index')->with('success', 'Estado actualizado correctamente.');
    }
}
