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

        // Bloquear intento de crear "superadmin"
        if (strtolower($data['name']) === 'superadmin') {
            return redirect()->back()->withErrors(['name' => 'No puedes crear un rol llamado "superadmin".'])->withInput();
        }

        $role = Role::create(['name' => $data['name']]);

        // ✅ Corrección: usar objetos Permission en lugar de IDs
        $permissions = Permission::whereIn('id', $data['permissions'] ?? [])->get();
        $role->syncPermissions($permissions);

        $source = $request->query('source', 'dashboard');

        return redirect()
            ->route('roles.index', ['source' => $source])
            ->with('success', 'Rol creado correctamente.');
    }

    public function edit(Request $request, Role $role)
    {
        if ($role->name === 'superadmin') {
            abort(403, 'El rol superadmin no puede ser editado.');
        }

        $permissions = Permission::all();
        $source = $request->query('source', 'dashboard');
        $layout = $source === 'dashboard2' ? 'layouts.dashboard2' : 'layouts.dashboard';

        return view('dashboard.roles.form', compact('role', 'permissions', 'source', 'layout'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'superadmin') {
            abort(403, 'El rol superadmin no puede ser modificado.');
        }

        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $data['name']]);

        // ✅ Corrección: usar objetos Permission en lugar de IDs
        $permissions = Permission::whereIn('id', $data['permissions'] ?? [])->get();
        $role->syncPermissions($permissions);

        $source = $request->query('source', 'dashboard');

        return redirect()
            ->route('roles.index', ['source' => $source])
            ->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Request $request, Role $role)
    {
        if ($role->name === 'superadmin') {
            return redirect()
                ->route('roles.index', ['source' => $request->query('source', 'dashboard')])
                ->with('error', 'No se puede eliminar el rol superadmin.');
        }

        $role->delete();

        return redirect()
            ->route('roles.index', ['source' => $request->query('source', 'dashboard')])
            ->with('success', 'Rol eliminado correctamente.');
    }
}
