<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\Bitacora;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\Faena;
use App\Models\Area;
use App\Models\Evaluacion;
use App\Models\PerfilEvaluacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\NotificacionGeneral;

class EvaluationController extends BaseApiController
{
    public function index()
    {
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
            'candidates'=>$candidates, 
            'empresas'=>$empresas, 
            'faenas'=>$faenas, 
            'areas'=>$areas,
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
        $perfilEvaluacion = $evaluacion->perfilEvaluacion;
        $sections = $perfilEvaluacion->secciones;
        $sections->each(function ($section) {
            $section->items = $section->items;
            $section->items->each(function ($item) {
                $item->competencia = $item->competencia;

            });
        });
        return $this->sendResponse([
            'evaluacion' => $evaluacion,
            'perfilEvaluacion' => $perfilEvaluacion,
            'sections' => $sections,
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
        $this->validate($request, [
            'rut' => 'required|exists:candidatos,rut',
            'perfil_evaluacion' => 'required|exists:perfil_evaluaciones,id',
            'cargo' => 'required',
            'evaluador' => 'required',
            'empresa' => 'required|exists:empresas,id',
            'faena' => 'required|exists:faenas,id',
            'area' => 'required|exists:areas,id',
        ]);
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
}