<?php
namespace App\Http\Controllers;

use App\Models\Producto; // Asegúrate de que estás usando el modelo correcto
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    // Método para generar el QR
    public function generarQr($id)
    {
        // Obtener el producto (planta) por su ID
        $producto = Producto::findOrFail($id); // Obtén el producto de la base de datos

        // Generar la URL para los cuidados específicos de la planta
        $urlCare = route('plant.care', ['id' => $producto->id]); // Aquí la URL es dinámica

        // Generar el QR con la URL de los cuidados de la planta
        $qr = QrCode::size(250)->generate($urlCare);

        // Retornar la vista con el QR
        return view('qr.index', compact('qr', 'producto'));
    }

    // Mostrar los cuidados de la planta específica
    public function showCare($id)
    {
        // Obtener el producto con sus cuidados
        $producto = Producto::findOrFail($id); // Usamos el ID para encontrar el producto

        // Mostrar la vista con los cuidados
        return view('qr.care', compact('producto'));
    }
}
