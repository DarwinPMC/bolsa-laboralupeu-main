<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Postulacion;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('message', 'Debes iniciar sesión para acceder al dashboard.');
        }

        if ($user->rol !== 'admin' && !$user->is_approved) {
            return redirect()->route('approval.wait')->with('message', 'Tu cuenta está en espera de aprobación.');
        }

        if ($user->rol === 'admin') {
            return view('components.welcome');
        }

        if ($user->rol === 'empresa') {
            $totalOfertas = Oferta::where('user_id', $user->id)->count();

            if ($totalOfertas == 0) {
                return view('components.welcome')->with('error', 'No tienes ofertas creadas.');
            }

            $ofertasIds = Oferta::where('user_id', $user->id)->pluck('id')->toArray();

            $totalPostulantes = Postulacion::whereIn('oferta_id', $ofertasIds)->count();

            $totalOfertasVencidas = Oferta::where('user_id', $user->id)
                ->where('oferta_disponible_hasta', '<', now())
                ->count();

            $totalOfertasPendientes = Oferta::where('user_id', $user->id)
                ->where('visible', false)
                ->count();

            return view('components.welcome', compact('totalOfertas', 'totalPostulantes', 'totalOfertasVencidas', 'totalOfertasPendientes'));
        }

        if ($user->rol === 'postulante') {
            $totalPostulaciones = Postulacion::where('user_id', $user->id)->count();

            if ($totalPostulaciones == 0) {
                return view('components.welcome')->with('error', 'No tienes postulaciones realizadas.');
            }

            return view('components.welcome', compact('totalPostulaciones'));
        }

        return view('components.welcome');
    }
}
