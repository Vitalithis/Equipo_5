<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $source = 'default';

        return view('dashboard.roles.index', compact('roles', 'source'));
    }

    public function create()
    {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('dashboard.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = \Spatie\Permission\Models\Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->pluck('name');
        $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Role $role)
    {
        if (in_array($role->name, ['admin', 'user'])) {
            return redirect()->route('roles.index')->with('error', 'Este rol no puede ser modificado.');
        }

        $permissions = Permission::all();
        $source = request()->get('source', 'default');

        return view('dashboard.roles.edit', compact('role', 'permissions', 'source'));
    }

    public function update(Request $request, Role $role)
    {
        if (in_array($role->name, ['admin', 'user'])) {
            return redirect()->route('roles.index')->with('error', 'Este rol no puede ser modificado.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->pluck('name');
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['admin', 'user'])) {
            return redirect()->route('roles.index')->with('error', 'Este rol no puede ser eliminado.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
