<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Oferta;

class EstadisticasController extends Controller
{
    public function index()
    {
        $numPostulantes = User::where('rol', 'postulante')->count();
        $numEmpresas = User::where('rol', 'empresa')->count();
        $numOfertas = Oferta::count();

        return view('welcome', compact('numPostulantes', 'numEmpresas','numOfertas'));
    }

}

