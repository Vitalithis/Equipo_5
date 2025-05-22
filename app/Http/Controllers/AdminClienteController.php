<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminClienteController extends Controller
{
    public function index()
    {
        // Obtener todos los clientes con el número de usuarios y productos
        $clientes = Cliente::withCount([
            'usuarios as total_usuarios',
            'productos as total_productos'
        ])->get();

        return view('admin.clientes.index', compact('clientes'));
    }

    public function usuarios(Cliente $cliente)
    {
        // Obtener todos los usuarios asociados al cliente
        $usuarios = User::where('cliente_id', $cliente->id)->get();
        return view('admin.clientes.usuarios', compact('cliente', 'usuarios'));
    }

    public function productos(Cliente $cliente)
    {
        // Obtener todos los productos asociados al cliente
        $productos = Producto::where('cliente_id', $cliente->id)->get();
        return view('admin.clientes.productos', compact('cliente', 'productos'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:clientes,slug',
        'email_admin' => 'required|email|unique:users,email',
        'password_admin' => 'required|string|min:6|confirmed',
    ]);

    // 1. Crear el cliente
    $cliente = Cliente::create([
        'nombre' => $request->nombre,
        'slug' => $request->slug,
    ]);

    // 2. Crear el usuario admin asociado al cliente
    $adminUser = User::create([
        'name' => $request->nombre,
        'email' => $request->email_admin,
        'password' => Hash::make($request->password_admin),
        'cliente_id' => $cliente->id,
    ]);

    // 3. Crear el rol admin para este cliente
    $adminRole = Role::firstOrCreate([
        'name' => 'admin',
        'guard_name' => 'web',
        'cliente_id' => $cliente->id,
    ]);

    // 4. Copiar permisos globales (cliente_id = null) y asignarlos al cliente
    $permisosGlobales = Permission::whereNull('cliente_id')->get();
    foreach ($permisosGlobales as $permisoGlobal) {
        // Crear una copia de los permisos globales para el cliente
        $nuevoPermiso = Permission::firstOrCreate([
            'name' => $permisoGlobal->name,
            'guard_name' => 'web',
            'cliente_id' => $cliente->id,  // Asignar el cliente_id al permiso
        ]);
        // Asignar el permiso al rol admin
        $adminRole->givePermissionTo($nuevoPermiso);
    }

    // 5. Asignar el rol admin al usuario
    $adminUser->assignRole($adminRole);

    // 6. Sincronizar los permisos del rol admin con los permisos del cliente
    $permissions = Permission::where('cliente_id', $cliente->id)->get();
    $adminRole->syncPermissions($permissions); // Sincronizar permisos con el rol admin

    // Redirigir con mensaje de éxito
    return redirect()->route('admin.clientes.index')->with('success', 'Cliente y admin creados exitosamente.');
}



    public function destroy($id)
    {
        // Buscar el cliente por su ID
        $cliente = Cliente::findOrFail($id);

        // Eliminar los usuarios relacionados con el cliente
        $cliente->usuarios()->delete();

        // Eliminar los productos relacionados con el cliente
        $cliente->productos()->delete();

        // Eliminar el cliente
        $cliente->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
    public function asignarPermisosExistente(Cliente $cliente)
{
    // 1. Buscar el rol admin del cliente
    $adminRole = Role::where('name', 'admin')->where('cliente_id', $cliente->id)->first();

    // Si no existe el rol admin para el cliente, retornar error
    if (!$adminRole) {
        return redirect()->route('admin.clientes.index')->with('error', 'Rol admin no encontrado para este cliente.');
    }

    // 2. Copiar los permisos globales (sin cliente_id) y asignarlos al cliente
    $permisosGlobales = Permission::whereNull('cliente_id')->get();
    foreach ($permisosGlobales as $permisoGlobal) {
        // Crear una copia de los permisos globales para el cliente
        $nuevoPermiso = Permission::firstOrCreate([
            'name' => $permisoGlobal->name,
            'guard_name' => 'web',
            'cliente_id' => $cliente->id,  // Asignar cliente_id al permiso
        ]);
        // Asignar el permiso al rol admin
        $adminRole->givePermissionTo($nuevoPermiso);
    }

    // 3. Sincronizar los permisos del rol admin con los permisos del cliente
    $permissions = Permission::where('cliente_id', $cliente->id)->get();
    $adminRole->syncPermissions($permissions); // Sincronizar permisos con el rol admin

    // 4. Retornar con mensaje de éxito
    return redirect()->route('admin.clientes.index')->with('success', 'Permisos asignados correctamente al cliente.');
}


}
