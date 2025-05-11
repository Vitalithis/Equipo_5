<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Categoria;
class ProductoController extends Controller
{
    public function home(Request $request)
    {
        // Obtener filtros desde la solicitud
        $tamano = $request->input('tamano');
        $categoria = $request->input('categoria');
        $dificultad = $request->input('dificultad');
        $ordenar_por = $request->input('filter2');
        $ordenar_ascendente = $request->input('filter3') === 'ascendente';

        // Construir consulta base
        $productos = Producto::query();

        // Aplicar filtros
        if ($tamano) {
            $productos->where('tamano', '<=', $tamano);
        }
        if ($categoria) {
            $productos->whereHas('categorias', function ($query) use ($categoria) {
                $query->where('nombre', $categoria);
            });
        }
        if ($dificultad) {
            $productos->where('nivel_dificultad', $dificultad);
        }

        // Aplicar ordenamiento
        if ($ordenar_por) {
            if ($ordenar_por == 'precio') {
                $productos->orderBy('precio', $ordenar_ascendente ? 'asc' : 'desc');
            } elseif ($ordenar_por == 'popularidad') {
                $productos->orderBy('popularidad', $ordenar_ascendente ? 'asc' : 'desc');
            } else {
                // Relevancia por defecto
                $productos->orderBy('created_at', $ordenar_ascendente ? 'asc' : 'desc');
            }
        }

        // Obtener los productos filtrados y paginados
        $productos = $productos->paginate(12); // Número de productos por página

        // Pasar los filtros a la vista para que se mantengan seleccionados
        return view('home', [
            'productos' => $productos,
            'tamano' => $tamano,
            'categoria' => $categoria,
            'dificultad' => $dificultad,
            'ordenar_por' => $ordenar_por,
            'ordenar_ascendente' => $ordenar_ascendente,
            'categorias' => Categoria::all(), // O las categorías que estés usando
        ]);
    }

    public function show($slug)
    {
        // Obtener el producto específico por su slug
        $producto = Producto::where('slug', $slug)->firstOrFail();

        // Obtener productos relacionados por categoría, excluyendo el producto actual
        $relacionados = Producto::where('categoria', $producto->categoria)
            ->where('id', '!=', $producto->id)
            ->take(3)
            ->get();

        // Pasar los datos a la vista
        return view('products.index', compact('producto', 'relacionados'));
    }

    // Función para filtrar productos por categoría desde el servidor
    public function filterByCategory($category)
    {
        $productos = Producto::where('categoria', $category)->get(); // Filtra productos por categoría

        return view('home', compact('productos'));
    }
    public function dashboard_show()
    {
        $productos = Producto::all();
        return view('dashboard.catalogo', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $dificultades = Producto::distinct()->pluck('nivel_dificultad');
        return view('dashboard.catalogo_edit', compact('categorias', 'dificultades'));
    }

    public function store(Request $request)
    {
        $producto = new Producto();
        $producto->fill($request->all());
        $producto->save();

        return redirect()->route('dashboard.catalogo')->with('success', 'Producto creado correctamente.');
    }
    public function edit($id)
    {

        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $dificultades = Producto::distinct()->pluck('nivel_dificultad');
        return view('dashboard\catalogo_edit', compact('producto', 'categorias', 'dificultades'));
    }
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return redirect()->route('dashboard.catalogo')->with('success', 'Producto actualizado correctamente.');
    }
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('dashboard.catalogo')->with('success', 'Producto eliminado correctamente.');
    }
}
