<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Rubro;
use App\Models\Oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Postulacion;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitacionOferta;

use Illuminate\Support\Facades\Storage;

class OfertaController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search');
    $user = Auth::user();

    $ofertasActualizadas = Oferta::where('visible', false)
        ->where('fecha_inicio', '<=', now())
        ->update(['visible' => true]);

    \Log::info("Ofertas actualizadas a visibles: " . $ofertasActualizadas);

    $ofertas = Oferta::withCount('postulaciones')
        ->where('user_id', $user->id)
        ->where('visible', true)
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', '%' . $search . '%')
                    ->orWhere('empresa', 'like', '%' . $search . '%')
                    ->orWhere('ubicacion', 'like', '%' . $search . '%');
            });
        })
        ->paginate(10);

    \Log::info("Ofertas visibles retornadas: " . $ofertas->count());

    return view('ofertas.index', compact('ofertas', 'search'));
}


    public function pendientes(Request $request)
    {
    \Log::info('Método pendientes ejecutado');

    $user = Auth::user();
    $ofertasPendientes = Oferta::where('user_id', $user->id)
        ->where('visible', false)
        ->paginate(10);

    return view('ofertas.pendientes', compact('ofertasPendientes'));
    }

    public function create()
    {
        $rubros = Rubro::all();
        return view('ofertas.create', compact('rubros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'requisitos' => 'nullable|string',
            'salario' => 'nullable|string',
            'rubro_id' => 'nullable|exists:rubros,id',
            'nuevo_rubro' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dia_inicio' => 'required|string',
            'dia_fin' => 'required|string',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'fecha_inicio' => 'required|date',
            'oferta_disponible_hasta' => 'required|date',
            'limite_postulantes'=> 'required|integer|min:1',

        ]);

        if ($request->filled('nuevo_rubro')) {
            $rubro = Rubro::create(['nombre' => $request->nuevo_rubro]);
            $request->merge(['rubro_id' => $rubro->id]);
        }

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('ofertas', 'public');
        }

        Oferta::create([
            'titulo' => $request->titulo,
            'empresa' => $request->empresa,
            'ubicacion' => $request->ubicacion,
            'descripcion' => $request->descripcion,
            'requisitos' => $request->requisitos,
            'salario' => $request->salario,
            'rubro_id' => $request->rubro_id,
            'dia_inicio' => $request->dia_inicio,
            'dia_fin' => $request->dia_fin,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'user_id' => Auth::id(),
            'imagen' => $imagenPath,
            'fecha_inicio' => $request->fecha_inicio,
            'oferta_disponible_hasta' => $request->oferta_disponible_hasta,
            'visible' => $request->fecha_inicio <= now() ? true : false,
            'limite_postulantes'=> $request->limite_postulantes,


        ]);

        return redirect()->route('ofertas.index')->with('success', 'Oferta creada exitosamente.');
    }

    public function show(Oferta $oferta)
    {
        $user = Auth::user();
        $esCreador = $user->id === $oferta->user_id;
        $esPostulante = $user->hasRole('postulante');

        $haVencido = $oferta->oferta_disponible_hasta < now();

        if (!$oferta->visible && $oferta->fecha_inicio <= now()) {
            $oferta->visible = true;
            $oferta->save();
        }

        if (!$esCreador && !$esPostulante) {
            abort(403, 'No autorizado.');
        }

        return view('ofertas.show', compact('oferta', 'haVencido'));
    }


    public function edit(Oferta $oferta)
    {
        if (Auth::id() !== $oferta->user_id) {
            abort(403, 'No autorizado.');
        }
        $rubros = Rubro::all();
        return view('ofertas.edit', compact('oferta', 'rubros'));
    }

    public function update(Request $request, Oferta $oferta)
    {
        if (Auth::id() !== $oferta->user_id) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'requisitos' => 'nullable|string',
            'salario' => 'nullable|string',
            'rubro_id' => 'nullable|exists:rubros,id',
            'nuevo_rubro' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dia_inicio' => 'required|string',
            'dia_fin' => 'required|string',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'fecha_inicio' => 'required|date',
            'oferta_disponible_hasta' => 'required|date|date_format:Y-m-d',
            'limite_postulantes' => 'required|integer|min:2',

        ]);

        if ($request->filled('nuevo_rubro')) {
            $rubro = Rubro::create(['nombre' => $request->nuevo_rubro]);
            $request->merge(['rubro_id' => $rubro->id]);
        }

        if ($request->hasFile('imagen')) {
            if ($oferta->imagen) {
                Storage::disk('public')->delete($oferta->imagen);
            }
            $imagenPath = $request->file('imagen')->store('ofertas', 'public');
            $oferta->imagen = $imagenPath;
        }
        $oferta->visible = $request->fecha_inicio <= now() ? true : false;

        $oferta->update($request->all());
        return redirect()->route('ofertas.index')->with('success', 'Oferta actualizada exitosamente.');
    }

    public function destroy(Oferta $oferta)
    {
        if (Auth::id() !== $oferta->user_id) {
            abort(403, 'No autorizado.');
        }
        if ($oferta->imagen) {
            Storage::disk('public')->delete($oferta->imagen);
        }
        $oferta->delete();
        return redirect()->route('ofertas.index')->with('success', 'Oferta eliminada exitosamente.');
    }

    public function postular(Request $request, Oferta $oferta)
{
    if ($oferta->limite_postulantes && $oferta->postulaciones()->count() >= $oferta->limite_postulantes) {
        return redirect()->back()->with('error', 'El límite de postulantes para esta oferta ha sido alcanzado.');
    }

    if ($oferta->oferta_disponible_hasta < now()) {
        return redirect()->back()->with('error', 'No puedes postularte a una oferta vencida.');
    }

    $cvPath = Auth::user()->archivo_cv;
    if (!$cvPath) {
        return redirect()->back()->with('error', 'Debes subir tu CV antes de postular a una oferta.');
    }

    $existePostulacion = Postulacion::where('user_id', Auth::id())
                                    ->where('oferta_id', $oferta->id)
                                    ->exists();
    if ($existePostulacion) {
        return redirect()->back()->with('error', 'Ya has postulado a esta oferta.');
    }

    try {
        Postulacion::create([
            'user_id' => Auth::id(),
            'oferta_id' => $oferta->id,
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al crear la postulación. Inténtalo nuevamente.');
    }

    return redirect()->back()->with('success', 'Te has postulado correctamente a la oferta.');
}


    public function verPostulantes(Oferta $oferta)
    {
        $user = Auth::user();

        if (!$user->hasRole('empresa')) {
            abort(403, 'No tienes permiso para ver los postulantes de esta oferta.');
        }

        $postulaciones = Postulacion::where('oferta_id', $oferta->id)
            ->with('usuario')
            ->paginate(10);

        return view('ofertas.postulantes', compact('oferta', 'postulaciones'));
    }

    public function cambiarFecha(Request $request, Oferta $oferta)
    {
        $request->validate([
            'oferta_disponible_hasta' => 'required|date',
        ]);

        $oferta->oferta_disponible_hasta = $request->oferta_disponible_hasta;
        $oferta->save();

        return response()->json(['success' => true]);
    }
    public function cambiarFechainicio(Request $request, $id)
    {
    $request->validate([
        'fecha_inicio' => 'required|date',
    ]);

    $oferta = Oferta::findOrFail($id);

    $oferta->fecha_inicio = $request->input('fecha_inicio');
    $oferta->save();


    return redirect()->route('ofertas.pendientes')->with('success', 'Fecha de inicio actualizada correctamente.');
    }
    public function invitarPostulantes(Request $request, Oferta $oferta)
    {
        $request->validate([
            'search' => 'required|string'
        ]);

        $postulantes = User::where('email', 'like', '%' . $request->search . '%')
                            ->orWhere('name', 'like', '%' . $request->search . '%')
                            ->get();

        if ($postulantes->isEmpty()) {
            return back()->with('error', 'No se encontraron postulantes con ese nombre o correo.');
        }

        $correoRemitente = auth()->user()->email;

        try {
            foreach ($postulantes as $postulante) {
                $nombreUsuario = $postulante->name;

                Mail::to($postulante->email)->send(new InvitacionOferta($oferta, $nombreUsuario, $correoRemitente));
            }

            return back()->with('success', 'Invitaciones enviadas correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un problema al enviar las invitaciones: ' . $e->getMessage());
        }
    }

    public function buscarPostulantes(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:1'
        ]);

        $postulantes = User::role('postulante')
                            ->where(function($query) use ($request) {
                                $query->where('email', 'like', '%' . $request->search . '%')
                                      ->orWhere('name', 'like', '%' . $request->search . '%');
                            })
                            ->select('id', 'name', 'email')
                            ->get();

        return response()->json($postulantes);
    }

    public function generarReportePostulante(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $postulaciones = Postulacion::with('oferta')
            ->where('user_id', auth()->id())
            ->when($fechaInicio, function ($query) use ($fechaInicio) {
                return $query->whereDate('created_at', '>=', $fechaInicio);
            })
            ->when($fechaFin, function ($query) use ($fechaFin) {
                return $query->whereDate('created_at', '<=', $fechaFin);
            })
            ->get();

        return view('postulante.reporte', compact('postulaciones', 'fechaInicio', 'fechaFin'));
    }

    public function generarReportePostulantePdf(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $postulaciones = Postulacion::with('oferta')
            ->where('user_id', auth()->id())
            ->when($fechaInicio, function ($query) use ($fechaInicio) {
                return $query->whereDate('created_at', '>=', $fechaInicio);
            })
            ->when($fechaFin, function ($query) use ($fechaFin) {
                return $query->whereDate('created_at', '<=', $fechaFin);
            })
            ->get();

        $nombreCompleto = auth()->user()->name;

        $fechaActual = now();

        $pdf = Pdf::loadView('postulante.reporte_pdf', compact('postulaciones', 'fechaInicio', 'fechaFin', 'nombreCompleto', 'fechaActual'));

        return $pdf->download('reporte_postulaciones_' . auth()->user()->name . '.pdf');
    }

    public function generarReportePostulanteExcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        return Excel::download(new PostulacionesExport($fechaInicio, $fechaFin, auth()->id()), 'reporte_postulaciones.xlsx');
    }


    public function mostrarFormularioReporteEmpresa()
    {
        $ofertas = Oferta::where('user_id', auth()->id())->get();

        return view('empresa.reporte', compact('ofertas'));
    }

    public function generarReporteEmpresaPdf(Request $request)
    {
        $ofertaId = $request->input('oferta_id');

        $oferta = Oferta::where('user_id', auth()->id())->findOrFail($ofertaId);

        $postulaciones = Postulacion::with('user')
            ->where('oferta_id', $ofertaId)
            ->get();

        $pdf = Pdf::loadView('empresa.reporte_pdf', compact('postulaciones', 'oferta'));

        return $pdf->download('reporte_postulaciones_oferta_' . $ofertaId . '.pdf');
    }

    public function generarReporteEmpresaExcel(Request $request)
    {
        $ofertaId = $request->input('oferta_id');

        $oferta = Oferta::where('user_id', auth()->id())->findOrFail($ofertaId);

        return Excel::download(new PostulacionesExport($ofertaId), 'reporte_postulaciones_oferta_' . $ofertaId . '.xlsx');
    }

    public function obtenerPostulantesPorOferta($ofertaId)
    {
        try {
            $oferta = Oferta::findOrFail($ofertaId);

            $postulaciones = Postulacion::with('user')
                ->where('oferta_id', $ofertaId)
                ->get();

            if ($postulaciones->isEmpty()) {
                return response()->json(['message' => 'No hay postulantes para esta oferta.'], 200);
            }

            return response()->json($postulaciones, 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Error: Oferta no encontrada - ID: ' . $ofertaId . ' | ' . $e->getMessage());
            return response()->json(['error' => 'La oferta laboral no fue encontrada.'], 404);

        } catch (\Exception $e) {
            \Log::error('Error al obtener postulantes: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener los postulantes.'], 500);
        }
    }

    public function estadisticasEmpresa()
    {
        $user = Auth::user();

        $totalOfertas = Oferta::where('user_id', $user->id)->count();

        $totalPostulantes = Postulacion::whereIn('oferta_id', Oferta::where('user_id', $user->id)->pluck('id'))->count();

        $totalOfertasVencidas = Oferta::where('user_id', $user->id)
            ->where('oferta_disponible_hasta', '<', now())
            ->count();

        $totalOfertasPendientes = Oferta::where('user_id', $user->id)
            ->where('visible', false)
            ->count();

        return view('welcome', compact('totalOfertas', 'totalPostulantes', 'totalOfertasVencidas', 'totalOfertasPendientes'));
    }


}

