<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use Illuminate\Http\Request;
use App\Models\Rubro;
use Illuminate\Support\Facades\Auth;

class BuscarOfertaController extends Controller
{
    public function index(Request $request)
    {
        $empresa = $request->input('empresa');
        $ubicacion = $request->input('ubicacion');
        $rubro_id = $request->input('rubro_id');
        $mostrarVencidas = $request->input('vencidas', false);
        $rubros = Rubro::all();

        $user = Auth::user();
        $esEmpresa = $user->hasRole('empresa');
        $esPostulante = $user->hasRole('postulante');

        $ofertas = Oferta::query();

        if ($esEmpresa) {
            $ofertas = $ofertas->where('user_id', $user->id);
        }

        if ($esPostulante) {
            if ($mostrarVencidas) {
                $ofertas = $ofertas->where('oferta_disponible_hasta', '<', now());
            } else {
                $ofertas = $ofertas->where('oferta_disponible_hasta', '>=', now());
            }
        }

        $ofertas = $ofertas->where('fecha_inicio', '<=', now());

        $ofertas = $ofertas->when($empresa, function($query, $empresa) {
                return $query->where('empresa', 'like', "%{$empresa}%");
            })
            ->when($ubicacion, function($query, $ubicacion) {
                return $query->where('ubicacion', 'like', "%{$ubicacion}%");
            })
            ->when($rubro_id, function($query, $rubro_id) {
                return $query->where('rubro_id', $rubro_id);
            })
            ->paginate(10);

        return view('buscar_oferta.index', compact('ofertas', 'rubros', 'mostrarVencidas'));
    }
}
