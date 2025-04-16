<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function home()
    {
        $categorias = Categoria::all(); // Todas las categorías
        return view('home', compact('categoria'));

    }

    public function show($id)
    {
        $categoria = Categoria::with('producto')->findOrFail($id); // Incluye productos relacionados
        return view('categoria.home', compact('categoria'));
    }
}
