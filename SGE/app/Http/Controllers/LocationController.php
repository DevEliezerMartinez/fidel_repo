<?php

namespace App\Http\Controllers;

use App\Models\Location; // Asegúrate de que el modelo de Location esté correctamente importado
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        // Obtener todas las ubicaciones de la base de datos
        $locations = Location::all();

        // Retornar las ubicaciones en formato JSON
        return response()->json([
            'locations' => $locations
        ]);
    }
}
