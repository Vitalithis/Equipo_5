<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
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

        $users = $query->get();
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

        $role = Role::where('name', $request->role)->first();

        if (!$role) {
            return redirect()->back()->with('error', 'El rol no existe.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'must_change_password' => true,
        ]);

        $user->assignRole($role);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        if ($user->email === 'admin@editha.com') {
            return back()->with('error', 'No puedes modificar este usuario protegido.');
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $role = Role::where('name', $request->role)->first();
        if ($role) {
            $user->syncRoles([$role]);
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        if ($user->email === 'admin@editha.com') {
            return back()->with('error', 'No puedes modificar este usuario protegido.');
        }

        $role = Role::where('name', $request->role)->first();

        if (!$role) {
            return back()->with('error', 'El rol no existe.');
        }

        $user->syncRoles([$role]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }
}
