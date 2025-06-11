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

        $layout = 'layouts.dashboard';

        return view('dashboard.users.index', compact('users', 'roles', 'layout'));
    }

    public function manageRoles()
    {
        $users = User::with('roles')->get();

        $roles = auth()->user()->hasRole('admin')
            ? Role::all()
            : Role::where('name', '!=', 'admin')->get();

        $layout = 'layouts.dashboard';

        return view('dashboard.users.index', compact('users', 'roles', 'layout'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $authUser = auth()->user();

        // ⚠️ Validaciones de seguridad
        if ($user->email === 'admin@editha.com') {
            return redirect()->back()->with('error', 'No puedes modificar el rol del administrador principal.');
        }

        if (
            $request->role === 'admin' &&
            (!$authUser->hasRole('admin') || $user->id === $authUser->id)
        ) {
            return redirect()->back()->with('error', 'No tienes permiso para asignar o autoasignarte el rol admin.');
        }

        if ($user->hasRole('admin') && !$authUser->hasRole('admin')) {
            return redirect()->back()->with('error', 'No puedes modificar a un administrador.');
        }

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Rol asignado correctamente.');
    }
}
