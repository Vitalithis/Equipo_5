<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    // Mostrar la vista de gestión de roles para usuarios
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('dashboard.roles.manage', compact('users', 'roles'));
    }

    // Actualizar el rol de un usuario
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Rol asignado correctamente.');
    }
}
