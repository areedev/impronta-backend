<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\CriterioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EscritorioController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\FaenaController;
use App\Http\Controllers\ItemPerfilEvaluacionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PerfilEvaluacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    Route::group(['middleware' => ['auth']], function () {

        Route::resource('/', EscritorioController::class);

        //Mantenedores
        Route::resource('faenas', FaenaController::class);
        Route::resource('areas', AreaController::class);
        Route::resource('itemperfilevaluaciones', ItemPerfilEvaluacionController::class);
        Route::resource('competencias', CompetenciaController::class);
        Route::resource('criterios', CriterioController::class);
        Route::resource('biblioteca', BibliotecaController::class);
        Route::resource('usuarios', UserController::class);

        //Modelos

        Route::resource('empresas', EmpresaController::class);
        Route::resource('candidatos', CandidatoController::class);

        Route::get('perfilevaluaciones/columna', [PerfilEvaluacionController::class, 'nueva_columna'])->name('perfilevaluaciones.columna');
        Route::post('perfilevaluaciones/competencia', [PerfilEvaluacionController::class, 'competencia'])->name('perfilevaluaciones.competencia');
        Route::post('perfilevaluaciones/descripcion', [PerfilEvaluacionController::class, 'descripcion'])->name('perfilevaluaciones.descripcion');
        Route::post('perfilevaluaciones/eliminarcolumna', [PerfilEvaluacionController::class, 'eliminar_columna'])->name('perfilevaluaciones.eliminarcolumna');
        Route::post('perfilevaluaciones/nuevaseccion', [PerfilEvaluacionController::class, 'nueva_seccion'])->name('perfilevaluaciones.nuevaseccion');
        Route::post('perfilevaluaciones/eliminarseccion', [PerfilEvaluacionController::class, 'eliminar_seccion'])->name('perfilevaluaciones.eliminarseccion');
        Route::resource('perfilevaluaciones', PerfilEvaluacionController::class);

        Route::get('evaluaciones/pdf/{id}', [EvaluacionController::class, 'pdf'])->name('evaluaciones.pdf');
        Route::get('evaluaciones/resultados/{id}', [EvaluacionController::class, 'resultados'])->name('evaluaciones.resultados');
        Route::get('evaluaciones/teorica/{id}', [EvaluacionController::class, 'teorica'])->name('evaluaciones.teorica.crear');
        Route::get('evaluaciones/pregunta', [EvaluacionController::class, 'nueva_pregunta'])->name('evaluaciones.teorica.nueva_pregunta');
        Route::get('evaluaciones/validar', [EvaluacionController::class, 'validar'])->name('evaluaciones.validar');
        Route::get('evaluaciones/practica/{id}', [EvaluacionController::class, 'practica'])->name('evaluaciones.practica');
        Route::get('evaluaciones/comentarios/{id}', [EvaluacionController::class, 'comentarios'])->name('evaluaciones.comentarios');
        Route::post('evaluaciones/comentarios/{id}', [EvaluacionController::class, 'comentarios_post'])->name('evaluaciones.comentarios_post');
        Route::post('evaluaciones/notas/{id}', [EvaluacionController::class, 'notas'])->name('evaluaciones.notas');
        Route::post('evaluaciones/teorica/{id}', [EvaluacionController::class, 'teorica_store'])->name('evaluaciones.teorica.post');
        Route::put('evaluaciones/teorica/{id}', [EvaluacionController::class, 'teorica_update'])->name('evaluaciones.teorica.update');
        Route::put('evaluaciones/estado/{id}', [EvaluacionController::class, 'actualizar_estado'])->name('evaluaciones.estado');
        Route::put('evaluaciones/informacion/{id}', [EvaluacionController::class, 'actualizar_informacion'])->name('evaluaciones.informacion');
        Route::resource('evaluaciones', EvaluacionController::class);

        Route::resource('reportes', ReporteController::class);

        Route::get('notificaciones/leer', [NotificacionController::class, 'leer'])->name('notificaciones.leer');
        Route::resource('notificaciones', NotificacionController::class);
        Route::get('ajustes/notificaciones', [NotificacionController::class, 'ajustes'])->name('ajustes.notificaciones');
        Route::post('notificaciones/actualizar', [NotificacionController::class, 'actualizar'])->name('notificaciones.actualizar');

        Route::get('buscar', [BuscadorController::class, 'buscar'])->name('buscar');


        //Perfil
        Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
        Route::post('/perfilupdate', [PerfilController::class, 'update'])->name('perfil.update');
        Route::get('/seguridad', [PerfilController::class, 'seguridad'])->name('perfil.seguridad');
        Route::post('/seguridadupdate', [PerfilController::class, 'updatePassword'])->name('update-password');


        //cerrar sesión
        Route::get('salir', [AuthController::class, 'signOut'])->name('cerrarsesion');
    });
    Route::get('informe-online/{id}', [EvaluacionController::class, 'public_pdf'])->name('pdfpublico');
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('loginpost', [AuthController::class, 'loginPost'])->name('login.post');
});
Route::get('404', function () {
    return view('404');
});
Route::fallback(function () {
    return redirect('404');
});
