<?php

namespace App\Http\Controllers;

use App\Models\Aprobacion;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\Perfil;
use App\Models\PerfilEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EscritorioController extends Controller
{
    function index()
    {
        $data['candidatos'] = Candidato::when(!Auth::user()->hasRole(['administrador', 'evaluador']), function ($query) {
            return $query->where('empresa_id', Auth::user()->perfil->empresa->id);
        })->count();
        $data['clientes'] = Empresa::count();
        $data['evaluaciones'] = Evaluacion::when(!Auth::user()->hasRole(['administrador', 'evaluador']), function ($query) {
            return $query->where('empresa_id', Auth::user()->perfil->empresa->id);
        })->count();
        $data['perfiles'] = PerfilEvaluacion::count();
        $data['evaluacionesPorPerfil'] = Evaluacion::when(!Auth::user()->hasRole(['administrador', 'evaluador']), function ($query) {
            return $query->where('empresa_id', Auth::user()->perfil->empresa->id);
        })->with('perfilEvaluacion')->select('perfil_evaluacion_id', DB::raw('count(*) as evaluaciones_count'))->groupBy('perfil_evaluacion_id')->get()->pluck('evaluaciones_count', 'perfilEvaluacion.nombre');
        $data['aprobaciones'] = Aprobacion::when(!Auth::user()->hasRole(['administrador', 'evaluador']), function ($query) {
            return $query->whereRelation('evaluacion', 'empresa_id', Auth::user()->perfil->empresa->id);
        })->select('estado', DB::raw('count(*) as count'))->groupBy('estado')->pluck('count');
        return view('escritorio', $data);
    }
}
