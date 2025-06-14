<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
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
        $clientes = Tenant::with('domains')->get();
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
            'nombre' => 'required|string',
            'subdominio' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($value);
                    if (Tenant::find($slug)) {
                        $fail("El subdominio '{$slug}' ya está en uso.");
                    }
                },
            ],
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|min:6|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $slug = Str::slug($request->subdominio);

            // Crear tenant con columnas reales
            $tenant = new Tenant();
            $tenant->id = $slug;
            $tenant->data = [
                'nombre' => $request->nombre,
                'activo' => false,
            ];
            $tenant->save();


            $tenant->domains()->create([
                'domain' => $slug . '.plantaseditha.me',
            ]);

            // Configurar dentro del contexto del nuevo tenant
            $tenant->run(function () use ($request, $slug) {
                $globalPermissions = Permission::all();
                $newPermissions = [];

                foreach ($globalPermissions as $permiso) {
                    if (!Permission::where('name', $permiso->name)->where('guard_name', $permiso->guard_name)->exists()) {
                        $clonado = $permiso->replicate();
                        $clonado->save();
                        $newPermissions[] = $clonado;
                    }
                }

                $adminRole = Role::firstOrCreate([
                    'name' => 'admin',
                    'guard_name' => 'web',
                ]);

                foreach ($newPermissions as $permiso) {
                    if (!$adminRole->hasPermissionTo($permiso)) {
                        $adminRole->givePermissionTo($permiso);
                    }
                }

                $adminUser = User::create([
                    'name' => 'Administrador ' . $slug,
                    'email' => $request->admin_email,
                    'password' => Hash::make($request->admin_password),
                    'must_change_password' => true,
                ]);

                $adminUser->assignRole($adminRole);
            });
        });

        return redirect()->route('clients.index')->with('success', 'Cliente creado con su usuario administrador.');
    }

    public function toggleActivo(Tenant $cliente)
    {
        $cliente->activo = !$cliente->activo;
        $cliente->save();

        return redirect()->route('clients.index')->with('success', 'Estado del cliente actualizado.');
    }

    public function show(Tenant $cliente)
    {
        $this->authorize('ver panel soporte');
        return view('client.show', compact('cliente'));
    }
}
