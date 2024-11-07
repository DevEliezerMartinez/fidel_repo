<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user(); // O también puedes usar auth()->user()

        // Pasar el usuario a la vista
        return view('dashboard', compact('user'));
    }
}
