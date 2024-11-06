<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;  // Asegúrate de importar Mail
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsuariosExport;
use App\Mail\UsuarioAprobado;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {

        if (Auth::user()->rol !== 'admin') {

            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $search = $request->get('search');
        $rol = $request->get('rol');

        $users = User::where('is_approved', 1)

        ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
            })
        ->when($rol, function ($query, $rol) {
                return $query->where('rol', $rol);
            })
            ->paginate(10);
        $pendingUsersCount = User::where('is_approved', false)->count();

        return view('usuario.index', compact('users', 'pendingUsersCount'));


    }


    public function create()
    {
        return view('usuario.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'dni' => 'nullable|digits:8|numeric|required_if:rol,postulante',
            'ruc' => 'nullable|digits:11|numeric|required_if:rol,empresa',
            'correo' => 'nullable|email',
            'celular' => 'nullable|string|max:20',
            'rol' => 'required|in:admin,empresa,postulante,supervisor',
            'archivo_cv' => 'nullable|file|max:2048',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->dni = $request->dni;
        $user->ruc = $request->ruc;
        $user->correo = $request->correo;
        $user->celular = $request->celular;
        $user->rol = $request->rol;

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo_path = $path;
        }

        if ($request->hasFile('archivo_cv')) {
            $cvPath = $request->file('archivo_cv')->store('cvs', 'public');
            $user->archivo_cv = $cvPath;
        }

        $user->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        return view('usuario.edit', compact('user'));
    }


    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);


    if (Auth::id() !== $user->id) {
        return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
    }


    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'dni' => ['nullable', 'digits:8', 'numeric', $user->rol == 'postulante' ? 'required' : ''],
        'ruc' => 'nullable|digits:11|numeric',
        'celular' => 'nullable|string|max:20',
        'archivo_cv' => 'nullable|file|max:2048',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->dni = $request->dni;
    $user->ruc = $request->ruc;
    $user->celular = $request->celular;

    if ($request->hasFile('profile_photo')) {
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $user->profile_photo_path = $request->file('profile_photo')->store('profile_photos', 'public');
    }

    if ($request->hasFile('archivo_cv')) {
        if ($user->archivo_cv) {
            Storage::disk('public')->delete($user->archivo_cv);
        }
        $user->archivo_cv = $request->file('archivo_cv')->store('cvs', 'public');
    }

    $user->save();

    return redirect()->route('dashboard')->with('success', 'Perfil actualizado exitosamente.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);


        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        if ($user->archivo_cv) {
            Storage::disk('public')->delete($user->archivo_cv);
        }

        $user->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
    public function pending(Request $request)
    {
        $search = $request->get('search');
        $rol = $request->get('rol');

        $users = User::where('is_approved', false)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when($rol, function ($query, $rol) {
                return $query->where('rol', $rol);
            })
            ->paginate(10);

        return view('usuario.pending', compact('users'));
    }

    public function approve($id)
    {
        // Buscar el usuario por su ID
        $user = User::findOrFail($id);

        // Cambiar el estado de aprobación del usuario
        $user->is_approved = 1;  // Cambiamos a aprobado
        $user->save();  // Guardamos el cambio en la base de datos

        // Enviar correo de notificación de aprobación
        Mail::to($user->email)->send(new UsuarioAprobado($user));

        // Redirigir con un mensaje de éxito
        return redirect()->route('usuarios.pending')->with('success', 'Usuario aprobado exitosamente y notificado por correo.');
    }
    public function show($id)
{
    $user = User::findOrFail($id);
    return view('usuario.show', compact('user'));
}
public function reporteResultados(Request $request)
{
    if (!Auth::user()->hasRole('admin')) {
        abort(403, 'No autorizado.');
    }

    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');
    $tipoReporte = $request->input('tipo_reporte');

    $postulantes = [];
    $empresas = [];

    if ($tipoReporte === 'postulantes') {
        $postulantes = User::where('rol', 'postulante')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->get();
    } elseif ($tipoReporte === 'empresas') {
        $empresas = User::where('rol', 'empresa')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->get();
    }

    return view('admin.reporte', compact('postulantes', 'empresas', 'fechaInicio', 'fechaFin', 'tipoReporte'));
}
public function descargarPDF(Request $request)
{
    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');
    $tipoReporte = $request->input('tipo_reporte');

    $postulantes = [];
    $empresas = [];

    if ($tipoReporte === 'postulantes') {
        $postulantes = User::where('rol', 'postulante')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->get();
    } elseif ($tipoReporte === 'empresas') {
        $empresas = User::where('rol', 'empresa')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->get();
    }

    $pdf = Pdf::loadView('admin.reporte_pdf', compact('postulantes', 'empresas', 'fechaInicio', 'fechaFin', 'tipoReporte'));

    return $pdf->download('reporte_' . $tipoReporte . '.pdf');
    }

    public function descargarExcel(Request $request)
    {
    return Excel::download(new UsuariosExport($request), 'reporte_' . $request->input('tipo_reporte') . '.xlsx');
    }
}
