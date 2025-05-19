<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->get();
        $source = $request->query('source', 'dashboard');
        $layout = $source === 'dashboard2' ? 'layouts.dashboard2' : 'layouts.dashboard';

        return view('dashboard.roles.index', compact('roles', 'source', 'layout'));
    }

    public function create(Request $request)
    {
        $permissions = Permission::all();
        $source = $request->query('source', 'dashboard');
        $layout = $source === 'dashboard2' ? 'layouts.dashboard2' : 'layouts.dashboard';

        return view('dashboard.roles.form', [
            'role' => null,
            'permissions' => $permissions,
            'source' => $source,
            'layout' => $layout,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        $source = $request->query('source', 'dashboard');

        return redirect()
            ->route('roles.index', ['source' => $source])
            ->with('success', 'Rol creado correctamente.');
    }


    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('dashboard.roles.form', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        $source = $request->query('source', 'dashboard');

        return redirect()
            ->route('roles.index', ['source' => $source])
            ->with('success', 'Rol actualizado correctamente.');
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado');
    }
}
