<?php

namespace App\Http\Controllers;

use App\Models\CorreoEnviado;
use Illuminate\Http\Request;

class CorreoController extends Controller
{
    /**
     * Mostrar la lista de correos enviados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $correos = CorreoEnviado::all();

        return view('correos.enviados', compact('correos'));
    }

    /**
     * Marcar un correo como leído.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function marcarLeido($id)
{
    $correo = CorreoEnviado::findOrFail($id);

    if (!$correo->leido) {
        $correo->leido = true;
        $correo->save();
    }

    return response()->file(storage_path('app/public/pixel.png'), [
        'Content-Type' => 'image/png',
        'Cache-Control' => 'no-store, no-cache, must-revalidate',
    ]);
}
}
