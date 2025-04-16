<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoCategoria;

class ProductCategory extends Controller
{
    public function index()
    {
        // Obtiene todos los registros de la tabla producto_categorias
        $categorias = ProductoCategoria::all();

        // Retorna la vista 'categorias.index' y le pasa los datos
        return view('categoria.home', compact('categoria'));
    }

    public function show($id)
    {
        // Obtiene un registro específico por ID
        $categoria = ProductoCategoria::findOrFail($id);

        return view('categoria.home', compact('categoria'));
    }
}
