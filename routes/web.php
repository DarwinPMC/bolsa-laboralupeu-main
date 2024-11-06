<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\RubroController;
use App\Http\Controllers\BuscarOfertaController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\EmpresaDashboardController;





Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('login', [LoginController::class, 'login'])->name('login.post');


Route::get('/waiting-for-approval', function () {
    return view('auth.waiting_for_approval');
})->name('approval.wait');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('usuarios/pending', [UsuarioController::class, 'pending'])->name('usuarios.pending');
Route::patch('usuarios/{id}/approve', [UsuarioController::class, 'approve'])->name('usuarios.approve');

Route::resource('usuarios', UsuarioController::class)->names([
    'index' => 'usuarios.index',
    'create' => 'usuarios.create',
    'store' => 'usuarios.store',
    'show' => 'usuarios.show',
    'edit' => 'usuarios.edit',
    'update' => 'usuarios.update',
    'destroy' => 'usuarios.destroy',


]);
Route::get('ofertas/pendientes', [OfertaController::class, 'pendientes'])->name('ofertas.pendientes');

Route::resource('ofertas', OfertaController::class)->names([
    'index' => 'ofertas.index',
    'create' => 'ofertas.create',
    'store' => 'ofertas.store',
    'show' => 'ofertas.show',
    'edit' => 'ofertas.edit',
    'update' => 'ofertas.update',
    'destroy' => 'ofertas.destroy',


]);

Route::get('/buscar_oferta', [BuscarOfertaController::class, 'index'])->name('buscar_oferta');
Route::post('/ofertas/{oferta}/postular', [OfertaController::class, 'postular'])->name('ofertas.postular');
Route::get('ofertas/{oferta}/postulantes', [OfertaController::class, 'verPostulantes'])->name('ofertas.postulantes');
Route::get('mis-postulaciones', [PostulacionController::class, 'index'])->name('postulaciones.index');

Route::delete('/postulaciones/{id}', [PostulacionController::class, 'destroy'])->name('postulaciones.destroy');
Route::get('postulaciones/estado', [PostulacionController::class, 'estadoPostulacion'])->name('postulaciones.estado');
Route::post('/postulantes/{id}/aceptar', [PostulacionController::class, 'aceptarPostulante'])->name('postulantes.aceptar');
Route::post('/postulantes/{id}/rechazar', [PostulacionController::class, 'rechazarPostulante'])->name('postulantes.rechazar');
Route::post('/postulantes/{id}/pendiente', [PostulacionController::class, 'pendientePostulante'])->name('postulantes.pendiente');


Route::post('postulaciones/{id}/eliminar', [PostulacionController::class, 'destroy'])->name('postulaciones.eliminar');
Route::post('/rubros', [RubroController::class, 'store'])->name('rubros.store');

Route::get('/', [EstadisticasController::class, 'index'])->name('home');
Route::get('/correos-enviados', [CorreoController::class, 'index'])->name('correos.enviados');

Route::get('/correos-enviados', [CorreoController::class, 'index'])->name('correos.enviados');
Route::get('/correos/{id}/leido', [CorreoController::class, 'marcarLeido'])->name('correos.marcarLeido');
Route::put('/ofertas/{oferta}/cambiar-fecha', [OfertaController::class, 'cambiarFecha'])->name('ofertas.cambiar-fecha');
Route::put('/ofertas/{oferta}/fecha-inicio', [OfertaController::class, 'cambiarFechainicio'])->name('ofertas.fecha_inicio');

Route::get('/admin/reportes', [UsuarioController::class, 'reporteResultados'])
    ->name('admin.reporte');
Route::post('/admin/reporte/pdf', [UsuarioController::class, 'descargarPDF'])->name('admin.reporte.pdf');
Route::post('/admin/reporte/excel', [UsuarioController::class, 'descargarExcel'])->name('admin.reporte.excel');

Route::post('/ofertas/{oferta}/invitar-postulantes', [OfertaController::class, 'invitarPostulantes'])->name('ofertas.invitar.postulantes');

Route::get('/buscar-postulantes', [OfertaController::class, 'buscarPostulantes'])->name('buscar.postulantes');
// Ruta para que la empresa genere el reporte de postulantes
Route::get('/oferta/{id}/reporte-pdf', [OfertaController::class, 'generarReportePdf'])->name('oferta.reporte.pdf');

// Ruta para mostrar el formulario de reporte del postulante
Route::get('/postulante/reporte', [OfertaController::class, 'generarReportePostulante'])->name('postulante.reporte');

// Ruta para generar el PDF del reporte (POST)
Route::post('/postulante/reporte-pdf', [OfertaController::class, 'generarReportePostulantePdf'])->name('postulante.reporte.pdf');

// Ruta para generar el Excel del reporte (POST)
Route::post('/postulante/reporte-excel', [OfertaController::class, 'generarReportePostulanteExcel'])->name('postulante.reporte.excel');
// Ruta para mostrar el formulario de selección de oferta y reporte
Route::get('/empresa/reporte', [OfertaController::class, 'mostrarFormularioReporteEmpresa'])->name('empresa.reporte');

// Ruta para generar el PDF del reporte de postulantes por oferta (POST)
Route::post('/empresa/reporte-pdf', [OfertaController::class, 'generarReporteEmpresaPdf'])->name('empresa.reporte.pdf');

// Ruta para generar el Excel del reporte de postulantes por oferta (POST)
Route::post('/empresa/reporte-excel', [OfertaController::class, 'generarReporteEmpresaExcel'])->name('empresa.reporte.excel');
Route::get('/empresa/reporte/postulantes/{ofertaId}', [OfertaController::class, 'obtenerPostulantesPorOferta'])->name('empresa.reporte.postulantes');

Route::get('/empresa/estadisticas', [OfertaController::class, 'obtenerEstadisticas']);
Route::get('/empresa-estadisticas', [EmpresaDashboardController::class, 'index']);
