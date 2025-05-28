<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
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
        return view('products.index', [
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
        return view('products.show', compact('producto', 'relacionados'));
    }

    public function filterByCategory(Request $request, $category)
    {
        // Obtener filtros desde la solicitud (igual que en home())
        $tamano = $request->input('tamano');
        $dificultad = $request->input('dificultad');
        $ordenar_por = $request->input('filter2');
        $ordenar_ascendente = $request->input('filter3') === 'ascendente';

        $productos = Producto::whereHas('categorias', function ($query) use ($category) {
            $query->where('nombre', $category);
        });

        if ($tamano) {
            $productos->where('tamano', '<=', $tamano);
        }
        if ($dificultad) {
            $productos->where('nivel_dificultad', $dificultad);
        }

        if ($ordenar_por) {
            if ($ordenar_por == 'precio') {
                $productos->orderBy('precio', $ordenar_ascendente ? 'asc' : 'desc');
            } elseif ($ordenar_por == 'popularidad') {
                $productos->orderBy('popularidad', $ordenar_ascendente ? 'asc' : 'desc');
            } else {
                $productos->orderBy('created_at', $ordenar_ascendente ? 'asc' : 'desc');
            }
        }
        $productos = $productos->paginate(12);
        // Retornar la misma vista con los datos necesarios
        return view('products.index', [
            'productos' => $productos,
            'tamano' => $tamano,
            'categoria' => $category, // La categoría fija de la ruta
            'dificultad' => $dificultad,
            'ordenar_por' => $ordenar_por,
            'ordenar_ascendente' => $ordenar_ascendente,
            'categorias' => Categoria::all(),
        ]);
    }

    public function filter(Request $request, ?string $category = null, ?int $tamano = null, ?string $dificultad = null, ?string $ordenar_por = null, ?bool $ordenar_ascendente = false)
    {
        // Validación básica de parámetros
        if ($category && !Categoria::where('nombre', $category)->exists()) {
            abort(404, 'Categoría no encontrada');
        }

        // Construcción de la consulta
        $productos = Producto::query()
            ->when($category, function ($query) use ($category) {
                $query->whereHas('categorias', function ($q) use ($category) {
                    $q->where('nombre', $category);
                });
            })
            ->when($tamano, function ($query) use ($tamano) {
                $query->where('tamano', '<=', $tamano);
            })
            ->when($dificultad, function ($query) use ($dificultad) {
                $query->where('nivel_dificultad', $dificultad);
            });

        $ordenar_por = $ordenar_por ?: 'created_at'; // Valor por defecto
        $direccion = $ordenar_ascendente ? 'asc' : 'desc';

        $productos->orderBy(
            match ($ordenar_por) {
                'precio' => 'precio',
                'popularidad' => 'popularidad',
                default => 'created_at'
            },
            $direccion
        );

        // Preparación de datos para la vista
        $categorias = Categoria::all()
            ->each(function ($cat) use ($category) {
                $cat->selected = $cat->nombre === $category;
            });

        return view('products.index', [
            'productos' => $productos->paginate(12),
            'tamano' => $tamano,
            'categoria' => $category,
            'dificultad' => $dificultad,
            'ordenar_por' => $ordenar_por,
            'ordenar_ascendente' => $ordenar_ascendente,
            'categorias' => $categorias,
            'dificultades' => Producto::distinct()->pluck('nivel_dificultad'),
        ]);
    }
    public function dashboard_show()
    {
        $productos = Producto::all();
        return view('dashboard.catalog.catalogo', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $dificultades = Producto::distinct()->pluck('nivel_dificultad');
        return view('dashboard.catalog.catalogo_edit', compact('categorias', 'dificultades'));
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
        return view('dashboard.catalog.catalogo_edit', compact('producto', 'categorias', 'dificultades'));
    }


public function update(Request $request, $id)
{
    $producto = Producto::findOrFail($id);

    // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric',
        // otros campos...
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10000',
    ]);

    // Manejo de imagen
    if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');

        // Eliminar imagen anterior si existía
        if ($producto->imagen && $producto->imagen !== 'storage/images/default-logo.png') {
            Storage::delete(str_replace('storage/', 'public/', $producto->imagen));
        }

        // Guardar nueva imagen
        $ruta = $imagen->store('public/images/productos');
        $producto->imagen = str_replace('public/', 'storage/', $ruta);
    } elseif (!$producto->imagen) {
        // Si no tiene imagen previa, usar la imagen por defecto
        $producto->imagen = 'storage/images/default-logo.png';
    }

    // Actualizar otros campos (excepto imagen, ya la tratamos aparte)
    $producto->fill($request->except('imagen'));

    $producto->save();

    return redirect()->route('dashboard.catalogo')->with('success', 'Producto actualizado correctamente.');
}

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('dashboard.catalog.catalogo')->with('success', 'Producto eliminado correctamente.');
    }
}
