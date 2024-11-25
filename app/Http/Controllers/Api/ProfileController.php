<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\Bitacora;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\PerfilEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends BaseApiController
{
    public function index()
    {
        $candidates = PerfilEvaluacion::select()
            ->get();
        return $this->sendResponse($candidates, 'Fetched data successfully');
    }
    public function show($id)
    {
        
    }
}