<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        $roles = auth()->user()->hasRole('admin')
            ? Role::all()
            : Role::where('name', '!=', 'admin')->get();

        $layout = 'layouts.dashboard'; // 👈 Aquí se define

        return view('dashboard.users.index', compact('users', 'roles', 'layout'));
    }

    public function manageRoles()
    {
        $users = User::with('roles')->get();

        $roles = auth()->user()->hasRole('admin')
            ? Role::all()
            : Role::where('name', '!=', 'admin')->get();

        $layout = 'layouts.dashboard'; // <- aquí defines el layout

        return view('dashboard.users.index', compact('users', 'roles', 'layout'));
    }
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $authUser = auth()->user();

        if ($user->email === 'admin@editha.com') {
            return redirect()->back()->with('error', 'No puedes modificar el rol del administrador principal.');
        }

        if ($request->role === 'admin' && $user->id === $authUser->id) {
            return redirect()->back()->with('error', 'No puedes darte a ti mismo el rol admin.');
        }

        if ($request->role === 'admin' && !$authUser->hasRole('admin')) {
            abort(403, 'No tienes permiso para asignar el rol admin.');
        }

        if ($user->hasRole('admin') && !$authUser->hasRole('admin')) {
            abort(403, 'No puedes modificar a un administrador.');
        }

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Rol asignado correctamente.');
    }
}
