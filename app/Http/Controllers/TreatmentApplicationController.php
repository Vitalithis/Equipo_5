<?php

namespace App\Http\Controllers;

use App\Models\TreatmentApplication;
use App\Models\PlantTreatment;
use App\Models\Producto;
use Illuminate\Http\Request;

class TreatmentApplicationController extends Controller
{
    public function index()
    {
        $applications = TreatmentApplication::with('treatment', 'producto')->latest()->get();
        return view('dashboard.treatments.historial', compact('applications'));
    }

/* public function create(Request $request)
{
    $productos = Producto::all();
    $treatments = PlantTreatment::all();
    $selected_treatment_id = $request->get('treatment_id');

    $latestApplications = TreatmentApplication::with('producto', 'treatment')
        ->latest('fecha_aplicacion')
        ->take(3)
        ->get();

    return view('dashboard.treatments.create', compact(
        'productos',
        'treatments',
        'selected_treatment_id',
        'latestApplications'
    ));
} */
    public function create(Request $request)
    {
        $productos = Producto::all();

        // Enviar id, nombre y frecuencia_aplicacion para que lo use el JS
        $treatments = PlantTreatment::select('id', 'nombre', 'frecuencia_aplicacion')->get();

        $selected_treatment_id = $request->get('treatment_id');

        $latestApplications = TreatmentApplication::with('producto', 'treatment')
            ->latest('fecha_aplicacion')
            ->take(3)
            ->get();

        return view('dashboard.treatments.create', compact(
            'productos',
            'treatments',
            'selected_treatment_id',
            'latestApplications'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'plant_treatment_id' => 'required|exists:plant_treatments,id',
            'fecha_aplicacion' => 'required|date',
            'dosis_aplicada' => 'nullable|string|max:100',
            'notas' => 'nullable|string|max:1000',
            'proxima_aplicacion' => 'nullable|date|after_or_equal:fecha_aplicacion',
        ]);

        $exists = TreatmentApplication::where('producto_id', $request->producto_id)
            ->where('plant_treatment_id', $request->plant_treatment_id)
            ->whereDate('fecha_aplicacion', $request->fecha_aplicacion)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Ya existe una aplicación registrada para este producto y tratamiento en esa fecha.');
        }

        TreatmentApplication::create($request->all());

        return redirect()->route('treatment_applications.create')->with('success', 'Aplicación registrada exitosamente.');
    }

    public function treatment()
    {
        return $this->belongsTo(PlantTreatment::class, 'plant_treatment_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

}
