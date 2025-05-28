<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with('roles');

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->get(); // Puedes usar ->paginate(10) si prefieres paginación
        $roles = Role::all();

        return view('dashboard.users.index', compact('users', 'roles'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('dashboard.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'must_change_password' => true,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Evitar cambiar el rol del admin principal
        if ($user->email === 'admin@editha.com') {
            return back()->with('error', 'No puedes modificar este usuario protegido.');
        }

        $user->syncRoles([$request->role]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }
}
