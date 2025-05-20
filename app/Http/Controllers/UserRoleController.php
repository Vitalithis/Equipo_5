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

        // Obtener todos los roles, excepto superadmin si el usuario autenticado no lo es
        $roles = auth()->user()->hasRole('superadmin')
            ? Role::all()
            : Role::where('name', '!=', 'superadmin')->get();

        return view('dashboard.roles.manage', compact('users', 'roles'));
    }

    // Actualizar el rol de un usuario
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $authUser = auth()->user();

        // No permitir que un usuario se asigne a sí mismo el rol superadmin
        if ($request->role === 'superadmin' && $user->id === $authUser->id) {
            return redirect()->back()->with('error', 'No puedes darte a ti mismo el rol superadmin.');
        }

        // Si el nuevo rol es superadmin, y el que hace el cambio no lo es
        if ($request->role === 'superadmin' && !$authUser->hasRole('superadmin')) {
            abort(403, 'No tienes permiso para asignar el rol superadmin.');
        }

        // Si el usuario objetivo ya tiene el rol superadmin, y quien hace el cambio no lo es
        if ($user->hasRole('superadmin') && !$authUser->hasRole('superadmin')) {
            abort(403, 'No puedes modificar a un superadmin.');
        }

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Rol asignado correctamente.');
    }
}
