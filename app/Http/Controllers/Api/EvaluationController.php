<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\Bitacora;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\Faena;
use App\Models\Area;
use App\Models\Evaluacion;
use App\Models\Aprobacion;
use App\Models\PerfilEvaluacion;
use App\Models\ResultadoEvaluacion;
use App\Models\CriterioDesempeñoInternoEvaluacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NotificacionGeneral;

class EvaluationController extends BaseApiController
{
    public function index()
    {
        $evaluations = Evaluacion::select()->get();
        $evaluations->each(function($e) {
            $e->candidato;
            $e->faena;
            $e->empresa;
            $e->area;
            $e->aprobacion;
            $e->perfilEvaluacion;
            $e->teorica;
        });
        $candidates = Evaluacion::select('e.*', 'p.nombre as faena_name', 'c.nombre as company_name', 'a.estado as approval_status')
            ->from('evaluaciones as e')
            ->join('faenas as p', 'e.faena_id', '=', 'p.id')
            ->join('empresas as c', 'e.empresa_id', '=', 'c.id')
            ->join('aprobaciones as a', 'a.evaluacion_id', '=', 'e.id')
            ->get();
        $empresas = Empresa::select()->get();
        $faenas = Faena::select()->get();
        $areas = Area::select()->get();
        $profileEvaluations = PerfilEvaluacion::get();

        return $this->sendResponse([
            'evaluations' => $evaluations,
            'candidates' => $candidates, 
            'empresas' => $empresas, 
            'faenas' => $faenas, 
            'areas' => $areas,
            'profileEvaluations' => $profileEvaluations
        ], 'Fetched data successfully');
    }
    public function show($id)
    {
        $candidate = Candidato::select('id', 'nombre', 'email', 'telefono', 'estado', 'foto', 'empresa_id')->find($id);
        if (is_null($candidate)) {
            return $this->sendError('Candidate not found.');
        }
        $empresa = Empresa::find($candidate->empresa_id);
        $empresaIds = Bitacora::where('candidato_id', $id)->pluck('empresa_nueva_id');
        $empresas = Empresa::whereIn('id', $empresaIds)->get();
        $evaluaciones = Evaluacion::where('candidato_id', $id)->get();
        return $this->sendResponse([
            'candidate' => $candidate,
            'empresa' => $empresa,
            'empresas' => $empresas,
            'evaluaciones' => $evaluaciones
        ], 'Fetched data successfully');
    }
    function practice($id)
    {
        $evaluacion = Evaluacion::find($id);

        // Lazy load the perfilEvaluacion relationship
        $evaluacion->perfilEvaluacion;
        $evaluacion->resultado;
        $evaluacion->criterios;
        $evaluacion->perfilEvaluacion->secciones;
        $evaluacion->perfilEvaluacion->secciones->each(function ($section) {
            $section->items;
            $section->items->each(function ($item) {
                $item->competencia;
                $item->competencia->criterios;

            });
        });
        return $this->sendResponse([
            'evaluacion' => $evaluacion,
            
        ], 'Fetched data successfully');
    }
    function validar(Request $request)
    {
        $this->validate($request, [
            'rut' => 'required',
        ]);
        $candidato = Candidato::where('rut', $request->rut)->first();
        
        if ($candidato) {
            $id = $candidato->empresa_id;
            $empresa = Empresa::find($id);
            $data['empresa'] = array($empresa->id => $empresa->nombre);
            $faenas = $empresa->faenas;
            $areas = $empresa->areas;
            $faenas = $faenas->pluck('faena.nombre', 'faena_id');
            $areas = $areas->pluck('area.nombre', 'area_id');
            $data['candidato'] = $candidato;
            $data['faenas'] = $faenas;
            $data['areas'] = $areas;
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        return response()->json($data);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rut' => 'required|exists:candidatos,rut',
            'perfil_evaluacion' => 'required|exists:perfil_evaluaciones,id',
            'cargo' => 'required',
            'evaluador' => 'required',
            'empresa' => 'required|exists:empresas,id',
            'faena' => 'required|exists:faenas,id',
            'area' => 'required|exists:areas,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $candidato = Candidato::where('rut', $request->rut)->first();
        $nuevo = new Evaluacion;
        $nuevo->candidato_id = $candidato->id;
        $nuevo->empresa_id  = $candidato->empresa_id;
        $nuevo->faena_id  = $request->faena;
        $nuevo->area_id  = $request->area;
        $nuevo->perfil_evaluacion_id = $request->perfil_evaluacion;
        $nuevo->cargo  = $request->cargo;
        $nuevo->evaluador_asignado  = $request->evaluador;
        $nuevo->fecha_solicitud = $request->fecha_solicitud;
        $nuevo->fecha_ejecucion = $request->fecha_ejecucion;
        $nuevo->fecha_emision  = $request->fecha_emision;
        $nuevo->certificado  = $request->certificado;
        $nuevo->equipo  = $request->equipo;
        $nuevo->marca  = $request->marca;
        $nuevo->modelo  = $request->modelo;
        $nuevo->year  = $request->year;
        $nuevo->usuario_creador = Auth::id();
        if ($nuevo->save()) {
            if ($request->hasFile('condiciones')) {
                $condiciones = $request->file('condiciones');
                $fileName = pathinfo($condiciones->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $condiciones->getClientOriginalExtension();
                $filePath = $condiciones->storeAs('evaluacion/' . $nuevo->id . '/condiciones/', $fileName, 'publico');
                $nuevo->condiciones = $fileName;
                $nuevo->save();
            }
            $notificacion = [
                'notificacion' => 'Se he creado una nueva evaluación para ' . $nuevo->candidato->nombre . ' con el perfil ' . $nuevo->perfilEvaluacion->nombre . '.',
                'url' => route('evaluaciones.show', $nuevo->id)
            ];
            $usuariosNot = User::where('notificaciones', true)->get();
            foreach ($usuariosNot as $usuariosNotificacion) {
                $usuariosNotificacion->notify(new NotificacionGeneral($notificacion));
            }
            return $this->sendResponse($nuevo, 'Evaluation created successfully');
        }
    }

    function notas(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nota' => 'required|array|numeric_array',
            'nota.*' => 'max_decimal',
            'archivo_comentario.*' => 'nullable|image|mimes:jpeg,png,gif,bmp',
            'archivo_comentario_criterio.*.*' => 'nullable|image|mimes:jpeg,png,gif,bmp',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        foreach ($request->nota as $key => $nota) {
            $nota = str_replace(',', '.', $nota);
            $resultado = ResultadoEvaluacion::updateOrCreate(
                ['evaluacion_id' => $id, 'item_id' => $key],
                ['nota' => $nota, 'porcentaje' => number_format(($nota / 4) * 100, 2), 'comentario' => $request->comentario[$key] ?: null]
            );
            if ($request->hasFile('archivo_comentario')) {
                if (!empty($request->file('archivo_comentario')[$key])) {
                    $archivo = $request->file('archivo_comentario')[$key];
                    $fileName = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                    $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                    $fileName = time() . '_' . $fileName . '.' . $archivo->getClientOriginalExtension();
                    $filePath = $archivo->storeAs('evaluacion/resultados/' . $resultado->id . '/', $fileName, 'publico');
                    $resultado->archivo = $fileName;
                    $resultado->save();
                }
            }
            if (isset($request->calificacion_criterio[$key])) {
                foreach ($request->calificacion_criterio[$key] as $keycriterio => $criterio) {
                    $criterioup = CriterioDesempeñoInternoEvaluacion::updateOrCreate(
                        ['evaluacion_id' => $id, 'criterio_id' => $keycriterio],
                        ['evaluacion_id' => $id, 'criterio_id' => $keycriterio, 'nota' => str_replace(',', '.', $request->calificacion_criterio[$key][$keycriterio]), 'comentarios' => $request->comentario_criterio[$key][$keycriterio]]
                    );
                    if (!empty($request->file('archivo_comentario_criterio')[$key][$keycriterio])) {
                        $archivo = $request->file('archivo_comentario_criterio')[$key][$keycriterio];
                        $fileName = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                        $fileName = time() . '_' . $fileName . '.' . $archivo->getClientOriginalExtension();
                        $filePath = $archivo->storeAs('evaluacion/resultados/criterios/' . $criterioup->id . '/', $fileName, 'publico');
                        $criterioup->archivo = $fileName;
                        $criterioup->save();
                    }
                }
            }
        }

        $evaluacion = Evaluacion::find($id);
        if ($evaluacion->estado <= 1) {
            $evaluacion->estado = 1;
            $evaluacion->save();
        }

        $this->aprobacion($id);

        $notificacion = [
            'notificacion' => 'Se asignaron calificaciones a la evaluación #' . $id . '.',
            'url' => route('evaluaciones.show', $id)
        ];
        $usuariosNot = User::where('notificaciones', true)->get();
        foreach ($usuariosNot as $usuariosNotificacion) {
            $usuariosNotificacion->notify(new NotificacionGeneral($notificacion));
        }

        return $this->sendResponse('', 'Datos guardados');
    }

    function aprobacion($id)
    {
        $evaluacion = Evaluacion::find($id);
        $existe = Aprobacion::where('evaluacion_id', $id)->get()->first();
        if ($existe) {
            $aprobacion = $existe;
        } else {
            $aprobacion = new Aprobacion();
        }
        $aprobacion->estado = 1;
        $aprobacion->evaluacion_id = $id;
        $porcentaje_practica = $evaluacion->porcentaje_practica;
        //comprobamos porcentaje evaluacion practica
        if ($porcentaje_practica < 75) {
            $aprobacion->estado = 0;
        }

        //comprobamos brechas teoricas
        $brechas = ResultadoEvaluacion::with(['itemPerfilEvaluacion', 'item', 'evaluacion.perfilEvaluacion.secciones.items'])->whereHas('evaluacion.perfilEvaluacion.secciones.items.competencia.tipo', function ($query) {
            $query->whereIn('abreviatura', ['CCC', 'CCCF']);
        })->where('nota', '<', 3.00)->where('evaluacion_id', $id)->get();

        if ($brechas->isNotEmpty()) {
            $competenciaIds = [];
            foreach ($brechas as $brecha) {
                if (isset($brecha->item->competencia_id)) {
                    $competenciaIds[] = $brecha->item->competencia_id;
                }
            }
            $aprobacion->estado = 0;
            $aprobacion->brechas_criticas = implode(',', $competenciaIds);
        }

        //comprobamos nota final
        if ($evaluacion->resultado->isNotEmpty() && isset($evaluacion->teorica->id)) {
            $nota = $evaluacion->nota_total + $evaluacion->teorica->nota_total;
            $porcentaje = $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total;
            if ($porcentaje < 80) {
                $aprobacion->estado = 0;
            }
            $aprobacion->nota = $nota;
            $aprobacion->porcentaje = $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total;
        }

        $aprobacion->save();
    }
}