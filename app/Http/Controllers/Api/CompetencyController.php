<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\User;
use App\Models\Competencia;
use App\Models\TipoCompetencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompetencyController extends BaseApiController
{
    public function index()
    {
        $competencias = Competencia::get();
        $tipos = TipoCompetencia::get();
        $competencias->each(function($competencia) {
            $competencia->tipo;
        });
        return $this->sendResponse([
            'competencias' => $competencias, 
            'types' => $tipos], 
        'Fetched data successfully');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'llave' => 'required',
            'tipo' => 'required',
        ]);

        $nuevo = new Competencia();
        $nuevo->tipo_competencia_id = $request->tipo;
        $nuevo->nombre = $request->nombre;
        $nuevo->llave = $request->llave;
        $nuevo->definicion = $request->definicion;
        $nuevo->proyecto = $request->proyecto;
        $nuevo->alcance = $request->alcance;
        $nuevo->tipo;
        if ($nuevo->save()) {
            return $this->sendResponse($nuevo, 'Saved data successfully');
        } else {
            return $this->sendError('Failed', 'Failed to save', 400);
        }
    }

    public function update(Request $request, $id)
    {
       $this->validate($request, [
            'nombre' => 'required',
            'llave' => 'required',
            'tipo' => 'required',
        ]);
        $competencia = Competencia::find($id);

        if ($competencia) {
            $competencia->tipo_competencia_id = $request->tipo;
            $competencia->nombre = $request->nombre;
            $competencia->llave = $request->llave;
            $competencia->definicion = $request->definicion;
            $competencia->proyecto = $request->proyecto;
            $competencia->alcance = $request->alcance;
            $competencia->tipo;

            if ($competencia->save()) {
                return $this->sendResponse($competencia,  'Competencia actualizada');
            }
        } else {
            return $this->sendError('failed', 'La competencia que intenta modificar no existe', 404);
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
        $competencia = Competencia::find($id);
        if ($competencia) {
            $competencia->delete();
            return $this->sendResponse($competencia, 'Faena eliminada');
        } else {
            return $this->sendError('Failed', 'Error while delete', 400);
        }
    }
}