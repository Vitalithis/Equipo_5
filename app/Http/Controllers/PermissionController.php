<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('dashboard.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('dashboard.permissions.form', ['permission' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create($data);

        return redirect()->route('permissions.index')->with('success', 'Permiso creado correctamente.');
    }

    public function edit(Permission $permission)
    {
        return view('dashboard.permissions.form', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($data);

        return redirect()->route('permissions.index')->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permiso eliminado correctamente.');
    }
}
