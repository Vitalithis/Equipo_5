<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ClienteCreado;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $clienteId = auth()->user()->cliente_id;


        $query = User::query()->with('roles');

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->get();
        $roles = Role::where('cliente_id', $clienteId)->get();

        return view('dashboard.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $clienteId = auth()->user()->cliente_id;

        $roles = Role::where('cliente_id', $clienteId)->get();

        return view('dashboard.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $clienteId = auth()->user()->cliente_id;


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $role = Role::where('name', $request->role)
            ->where('cliente_id', $clienteId)
            ->first();

        if (!$role) {
            return redirect()->back()->with('error', 'El rol no pertenece a este cliente.');
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

    public function updateRole(Request $request, User $user)
    {
        $clienteId = auth()->user()->cliente_id;

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        if ($user->email === 'admin@editha.com') {
            return back()->with('error', 'No puedes modificar este usuario protegido.');
        }

        $role = Role::where('name', $request->role)
            ->where('cliente_id', $clienteId)
            ->first();

        if (!$role) {
            return back()->with('error', 'El rol no pertenece a este cliente.');
        }

        $user->syncRoles([$role]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }
    public function frecuentes()
    {
        $clienteId = auth()->user()->cliente_id;

        $frequentClients = User::where('cliente_id', $clienteId)
            ->withCount(['pedidos' => function ($query) {
                $query->whereNotNull('estado_pedido'); // Opcional: filtra solo pedidos válidos
            }])
            ->having('pedidos_count', '>', 5)
            ->get();

        return view('dashboard.users.frequent', compact('frequentClients'));
    }
    public function asignarDescuento(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'descuento' => 'required|numeric|min:0|max:100',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->descuento_personalizado = $request->descuento;
        $user->save();

        return response()->json(['message' => 'Descuento asignado con éxito']);
    }
}
