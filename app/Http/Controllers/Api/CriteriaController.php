<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\User;
use App\Models\CriterioDesempeñoInterno;
use App\Models\TipoCompetencia;
use App\Models\Competencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CriteriaController extends BaseApiController
{
    public function index()
    {
        $criterias = CriterioDesempeñoInterno::get();
        $tipos = TipoCompetencia::get();
        $competencias = Competencia::get();
        $criterias->each(function($criteria) {
            $criteria->competencia;
            $criteria->competencia->tipo;
        });
        return $this->sendResponse([
            'criterias' => $criterias,
            'tipos' => $tipos,
            'competencias' => $competencias
        ], 'Fetched data successfully');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'competencia' => 'required',
            'criterio' => 'required',
            'llave' => 'required',
        ]);

        $nuevo = new CriterioDesempeñoInterno();
        $nuevo->competencia_id = $request->competencia;
        $nuevo->criterio = $request->criterio;
        $nuevo->llave = $request->llave;
        $nuevo->competencia;
        $nuevo->competencia->tipo;

        if ($nuevo->save()) {
            return $this->sendResponse($nuevo, 'Saved data successfully');
        } else {
            return $this->sendError('Failed', 'Failed to save', 400);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'competencia' => 'required',
            'criterio' => 'required',
            'llave' => 'required',
        ]);
        $criteria = CriterioDesempeñoInterno::find($id);
        if($criteria){
            $criteria->competencia_id = $request->competencia;
            $criteria->criterio = $request->criterio;
            $criteria->llave = $request->llave;
            if($criteria->save()) {            
                $criteria->competencia;
                $criteria->competencia->tipo;
                return $this->sendResponse($criteria, 'Saved data successfully');
            }
        } else {
            return $this->sendError('Failed', 'La criteria que intenta modificar no existe', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $criteria = CriterioDesempeñoInterno::find($id);
        if ($criteria) {
            $criteria->delete();
            return $this->sendResponse($criteria, 'Criteria eliminada');
        } else {
            return $this->sendError('Failed', 'Error while delete', 400);
        }
    }
}