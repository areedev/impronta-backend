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
use App\Models\SeccionPerfilEvaluacion;
use App\Models\ItemSeccionPerfilEvaluacion;
use App\Models\ItemPerfilEvaluacion;
use App\Models\TipoCompetencia;
use App\Models\Competencia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Notifications\NotificacionGeneral;

class ProfileEvaluationController extends BaseApiController
{
    public function index()
    {
        $candidates = PerfilEvaluacion::select()
            ->get();
        return $this->sendResponse($candidates, 'Fetched data successfully');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $nuevo = new PerfilEvaluacion();
        $nuevo->nombre = $request->nombre;
        $nuevo->usuario_creador = Auth::id();
        if ($nuevo->save()) {
            // $seccion = new SeccionPerfilEvaluacion();
            // $seccion->perfil_evaluacion_id = $nuevo->id;
            // $seccion->save();
            return $this->sendResponse($nuevo, 'Profile created successfully');
        } else {
            return $this->sendError('Profile not created.', '', 400);
        }
    }
    public function edit($id)
    {
        $perfil = PerfilEvaluacion::find($id);
        $perfil->secciones = $perfil->secciones;
        $perfil->secciones->each(function ($section) {
            $section->items = $section->items;
            $section->items->each(function ($item) {
                $item->competencia = $item->competencia;
            });
        });
        $items = ItemPerfilEvaluacion::get();
        $tipos = TipoCompetencia::get();
        $competencies = Competencia::get();
        return $this->sendResponse([
            'profile'=>$perfil,
            'items'=>$items,
            'tipos'=>$tipos,
            'competencias' => $competencies
        ], 'Fetched profile evaluation data');
    }

    public function destroy($id)
    {
        $perfil = PerfilEvaluacion::find($id);
        if ($perfil) {
            $perfil->delete();
            return $this->sendResponse('',  'Perfil eliminado');
        } else {
            return $this->sendError('Error', 'Error', 400);
        }

    }

    function nueva_seccion(Request $request)
    {
        $this->validate($request, [
            'perfil' => 'required',
        ]);

        $lastseccion = SeccionPerfilEvaluacion::where('perfil_evaluacion_id', $request->perfil)->latest()->first();
        $seccion = new SeccionPerfilEvaluacion();
        $seccion->perfil_evaluacion_id = $request->perfil;
        if ($lastseccion == null) {
            $seccion->orden = 1;
        } else {
            $seccion->orden = $lastseccion->orden + 1;
        }
        // $seccion->orden = $lastseccion->orden + 1;
        if ($seccion->save()) {
            return $this->sendResponse(['section'=>$seccion], 'Section created successfully');
        } else {
            return $this->sendError('Failed', 'Failed', 400);
        }
    }

    function nueva_columna(Request $request)
    {
        $this->validate($request, [
            'perfil' => 'required',
            'seccion' => 'required',
        ]);
        $item = new ItemSeccionPerfilEvaluacion();
        $item->seccion_id = $request->seccion;
        if ($item->save()) {
            $items = ItemPerfilEvaluacion::get();
            $tipos = TipoCompetencia::get();
            $seccion = $request->seccion;
            return $this->sendResponse(['item'=>$item, 'items'=>$items, 'types'=>$tipos], 'Column created successfully');
        } else {
            return $this->sendError('Failed', 'Failed', 400);
        }
    }

    function competencies(Request $request){
        $this->validate($request, [
            'tipo' => 'required',
        ]);
        $search = $request->search;
        $id = $request->tipo;
        if ($search == '') {
            $items = Competencia::orderby('nombre', 'asc')->where('tipo_competencia_id', $id)->get();
        } else {
            $items = Competencia::orderby('nombre', 'asc')->where('tipo_competencia_id', $id)->where('nombre', 'like', '%' . $search . '%')->get();
        }

        $response = array();
        foreach ($items as $item) {
            $response[] = array(
                "id" => $item->id,
                "text" => $item->nombre
            );
        }
        return $this->sendResponse($items, 'Fetched competencies successfully');
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'nombre_seccion' => 'required'
        ]);
        $perfil = PerfilEvaluacion::find($id);
        if ($perfil) {
            $perfil->nombre = $request->nombre;
            if ($perfil->save()) {

                $orden = 1;
                foreach ($request->nombre_seccion as $llaveseccion => $seccion) {
                    SeccionPerfilEvaluacion::updateOrInsert(
                        ['id' => $llaveseccion],
                        ['nombre' => $seccion, 'orden' => $orden]
                    );
                    if(isset($request->competencia[$llaveseccion])){
                        foreach ($request->competencia[$llaveseccion] as $llaveitem => $item) {
                            if($item != ''){
                                ItemSeccionPerfilEvaluacion::updateOrInsert(
                                    ['id' => $llaveitem, 'seccion_id' => $llaveseccion],
                                    ['competencia_id' => $item]
                                );
                             } else {
                                ItemSeccionPerfilEvaluacion::find($llaveitem)->delete();
                             }
                        }
                    }
                    $orden++;
                }

                return $this->sendResponse('success',  'Perfil actualizado');
            }
        } else {
            return $this->sendError('El perfil que intenta modificar no existe', '', 404);
        }
    }
}