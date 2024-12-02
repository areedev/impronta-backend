<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AreaController extends BaseApiController
{
    public function index()
    {
        $faenas = Area::get();
        $faenas->each(function($faena) {
            $faena->creador;
        });
        return $this->sendResponse($faenas, 'Fetched data successfully');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
        ]);

        $nuevo = new Area();
        $nuevo->nombre = $request->nombre;
        $nuevo->usuario_creador = Auth::id();
        $nuevo->creador;
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
        ]);
        $faena = Area::find($id);
        if($faena){
            $faena->nombre = $request->nombre;
            if($faena->save()) {            
                $faena->creador;
                return $this->sendResponse($faena, 'Saved data successfully');
            }
        } else {
            return $this->sendError('Failed', 'La faena que intenta modificar no existe', 400);
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
        $faena = Area::find($id);
        if ($faena) {
            $faena->delete();
            return $this->sendResponse($faena, 'Faena eliminada');
        } else {
            return $this->sendError('Failed', 'Error while delete', 400);
        }
    }
}