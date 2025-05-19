<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< Updated upstream
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Permission;
=======
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
>>>>>>> Stashed changes

class RoleController extends Controller
{
    public function index()
    {
<<<<<<< Updated upstream
    $roles = Role::with('permissions')->get();
    return view('dashboard.roles.index', compact('roles'));
    }


=======
        $roles = Role::with('permissions')->get();
        return view('dashboard.roles.roles', compact('roles'));
    }

>>>>>>> Stashed changes
    public function create()
    {
        $permissions = Permission::all();
        return view('dashboard.roles.form', ['role' => null, 'permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $data['name']]);
        $role->syncPermissions($data['permissions']);

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
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
            'permissions' => 'array',
<<<<<<< Updated upstream
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
=======
>>>>>>> Stashed changes
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions']);
<<<<<<< Updated upstream
        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions']);
=======
>>>>>>> Stashed changes

        return redirect()->route('roles.index')->with('success', 'Rol actualizado');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado');
<<<<<<< Updated upstream
        return redirect()->route('roles.index')->with('success', 'Rol actualizado');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado');
=======
>>>>>>> Stashed changes
    }
}
