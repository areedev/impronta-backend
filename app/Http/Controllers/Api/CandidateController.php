<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\Bitacora;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CandidateController extends BaseApiController
{
    public function index()
    {
        $candidates = Candidato::select('id', 'nombre', 'email', 'telefono', 'estado', 'foto')->get();
        return $this->sendResponse($candidates, 'Fetched data successfully');
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
            'evaluaciones' => $evaluaciones,
        ], 'Fetched data successfully');
    }
}