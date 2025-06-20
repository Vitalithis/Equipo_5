<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $this->authorize('ver panel soporte');
        $clientes = Cliente::all();
        return view('client.index', compact('clientes'));
    }

    public function create()
    {
        $this->authorize('crear cliente');
        return view('client.create');
    }

    public function store(Request $request)
    {
        $this->authorize('crear cliente');

        $request->validate([
            'nombre' => 'required|string|unique:clientes,nombre',
            'subdominio' => 'required|string|unique:clientes,subdominio',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|min:6|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Crear cliente
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'subdominio' => Str::slug($request->subdominio),
                'slug' => Str::slug($request->nombre),
                'activo' => true,
            ]);

            // 2. Clonar permisos globales
            $globalPermissions = Permission::whereNull('cliente_id')->get();
            $newPermissions = [];

            foreach ($globalPermissions as $permiso) {
                $clonado = $permiso->replicate();
                $clonado->cliente_id = $cliente->id;
                $clonado->save();
                $newPermissions[] = $clonado;
            }

            // 3. Crear rol admin exclusivo para este cliente
            $adminRole = Role::create([
                'name' => 'admin',
                'guard_name' => 'web',
                'cliente_id' => $cliente->id,
            ]);

            // 4. Asignar permisos clonados al rol
            foreach ($newPermissions as $permiso) {
                $adminRole->givePermissionTo($permiso);
            }

            // 5. Crear usuario administrador
            $adminUser = User::create([
                'name' => 'Administrador ' . $cliente->nombre,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'cliente_id' => $cliente->id,
                'must_change_password' => true,
            ]);

            // 6. Asignar rol admin con cliente_id manualmente
            DB::table('model_has_roles')->insert([
                'role_id' => $adminRole->id,
                'model_type' => User::class,
                'model_id' => $adminUser->id,
                'cliente_id' => $cliente->id,
            ]);
        });

        return redirect()->route('clients.index')->with('success', 'Cliente creado con su usuario administrador.');
    }


    public function toggleActivo(Cliente $cliente)
    {
        $cliente->activo = !$cliente->activo;
        $cliente->save();

        return redirect()->route('clients.index')->with('success', 'Estado del cliente actualizado.');
    }
}
