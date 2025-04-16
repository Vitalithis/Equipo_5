<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function home()
    {
        $categoria = Categoria::all(); // Todas las categorías
        return view('home', compact('categorias'));

    }

    public function show($id)
    {
        $categoria = Categoria::with('productos')->findOrFail($id); // Incluye productos relacionados
        return view('categorias.home', compact('categorias'));
    }
}
