<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        // Solo superadmins pueden acceder a estos métodos
        $this->middleware('auth');
        $this->middleware('can:superadmin'); // Asegúrate de tener este middleware/policy
    }

    /**
     * Obtener todos los usuarios (para API)
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Actualizar rol de usuario (para API)
     */
    public function updateRole(User $user, Request $request)
    {
        $request->validate([
            'role' => 'required|in:superadmin,admin,user' // Roles permitidos
        ]);

        $user->update(['role' => $request->role]);

        return response()->json(['message' => 'Rol actualizado']);
    }
}