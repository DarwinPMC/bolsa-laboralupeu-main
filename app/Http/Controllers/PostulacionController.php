<?php

namespace App\Http\Controllers;

use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\CorreoEnviado;

use App\Mail\PostulacionAceptadaMail;


class PostulacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Postulacion::where('user_id', Auth::id())->with('oferta');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('oferta', function ($q) use ($search) {
                $q->where('titulo', 'like', '%' . $search . '%')
                  ->orWhere('empresa', 'like', '%' . $search . '%')
                  ->orWhere('ubicacion', 'like', '%' . $search . '%');
            });
        }

        $postulaciones = $query->paginate(10);

        return view('postulaciones.index', compact('postulaciones'));
    }

    public function aceptarPostulante($id)
{
    $postulacion = Postulacion::findOrFail($id);

    $postulacion->estado = 'aceptado';
    $postulacion->save();

    $usuarioAutenticado = auth()->user();

    $correoRemitente = $usuarioAutenticado->correo ?? $usuarioAutenticado->email;

    $correoEnviado = CorreoEnviado::create([
        'destinatario' => $postulacion->usuario->email,
        'estado' => 'Enviado',
        'leido' => false
    ]);

    Mail::mailer('smtp')
        ->to($postulacion->usuario->email)
        ->send(new PostulacionAceptadaMail($postulacion, $correoRemitente, $correoEnviado));

    return redirect()->back()->with('success', 'El postulante ha sido aceptado exitosamente y se ha enviado el correo.');
}


    public function rechazarPostulante($id)
    {
        $postulacion = Postulacion::findOrFail($id);

        $postulacion->estado = 'rechazado';
        $postulacion->save();

        return redirect()->back()->with('success', 'El postulante ha sido rechazado.');
    }
    public function pendientePostulante($id)
{
    $postulacion = Postulacion::findOrFail($id);
    $postulacion->estado = 'pendiente';
    $postulacion->save();

    return redirect()->back()->with('success', 'La acción ha sido cancelada. El postulante ha vuelto a estar en estado pendiente.');
}


    public function estadoPostulacion()
    {
        $postulaciones = Postulacion::where('user_id', Auth::id())->with('oferta')->get();

        return view('postulaciones.estado', compact('postulaciones'));
    }

    public function destroy($id)
    {
        $postulacion = Postulacion::findOrFail($id);

        $postulacion->delete();

        return redirect()->route('postulaciones.index')->with('success', 'La postulación ha sido eliminada exitosamente.');
    }
}
