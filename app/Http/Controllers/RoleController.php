<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $clienteId = app('clienteActual')->id;

        $roles = Role::with('permissions')
            ->where('cliente_id', $clienteId)
            ->get();

        $source = 'default';

        return view('dashboard.roles.index', compact('roles', 'source'));
    }

    public function create()
    {
        $clienteId = app('clienteActual')->id;

        $permissions = Permission::where('cliente_id', $clienteId)->get();

        return view('dashboard.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $clienteId = app('clienteActual')->id;

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'cliente_id' => $clienteId,
        ]);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)
                ->where('cliente_id', $clienteId)
                ->pluck('name');

            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Role $role)
    {
        $clienteId = app('clienteActual')->id;

        if ($role->cliente_id !== $clienteId || in_array($role->name, ['admin', 'user'])) {
            return redirect()->route('roles.index')->with('error', 'No autorizado o rol protegido.');
        }

        $permissions = Permission::where('cliente_id', $clienteId)->get();
        $source = request()->get('source', 'default');

        return view('dashboard.roles.edit', compact('role', 'permissions', 'source'));
    }

    public function update(Request $request, Role $role)
    {
        $clienteId = app('clienteActual')->id;

        if ($role->cliente_id !== $clienteId || in_array($role->name, ['admin', 'user'])) {
            return redirect()->route('roles.index')->with('error', 'No autorizado o rol protegido.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions ?? [])
            ->where('cliente_id', $clienteId)
            ->pluck('name');

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        $clienteId = app('clienteActual')->id;

        if ($role->cliente_id !== $clienteId || in_array($role->name, ['admin', 'user'])) {
            return redirect()->route('roles.index')->with('error', 'No autorizado o rol protegido.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
