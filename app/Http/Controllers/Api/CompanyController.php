<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\Bitacora;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\PerfilEvaluacion;
use App\Models\Faena;
use App\Models\FaenaEmpresa;
use App\Models\Area;
use App\Models\AreaEmpresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\DB;

class CompanyController extends BaseApiController
{
    public function index()
    {
        $candidates = Empresa::select()
            ->get();
        return $this->sendResponse($candidates, 'Fetched data successfully');
    }
    public function show($id)
    {
        
    }
    public function edit($id)
    {
        $empresa = Empresa::find($id);
        if ($empresa != null) {
            $empresa->faenas = $empresa->faenas;
            $empresa->areas = $empresa->areas;
        }
        $faenas = Faena::get();
        $areas = Area::get();
        $users = User::select('id', 'email')->get();
        $users->each(function ($user) {
            $user->perfil = $user->perfil;
            $user->perfil->email = $user->email;
        });
        return $this->sendResponse([
            'empresa' => $empresa,
            'faenas' => $faenas,
            'areas' => $areas,
            'users' => $users
        ], 'fetched successfully');
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'rut' => 'required',
            'contacto' => 'required',
            'usuario' => 'nullable|exists:users,id',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:3000'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $empresa = new Empresa();
        if (Empresa::find($id) != null) {
            $empresa = Empresa::find($id);
        }

        // if (Rut::parse($request->rut)->validate()) {
        //     $empresa->rut = $request->rut;
        // }
        $empresa->rut = $request->rut;
        $empresa->user_id = $request->usuario;
        $empresa->nombre = $request->nombre;
        $empresa->contacto = $request->contacto;
        $empresa->email = $request->email;
        $empresa->telefono_contacto = $request->telefono;

        $faena = json_decode($request->faena);
        $area = json_decode($request->area);
        if ($empresa->save()) {
            AreaEmpresa::whereNotIn('area_id', $area)->where('empresa_id', $empresa->id)->delete();
            FaenaEmpresa::whereNotIn('faena_id', $area)->where('empresa_id', $empresa->id)->delete();
            foreach ($area as $item) {
                AreaEmpresa::updateOrInsert(
                    ['empresa_id' => $empresa->id, 'area_id' => $item],
                    ['empresa_id' => $empresa->id, 'area_id' => $item]
                );
            }
            foreach ($faena as $item) {
                FaenaEmpresa::updateOrInsert(
                    ['empresa_id' => $empresa->id, 'faena_id' => $item],
                    ['empresa_id' => $empresa->id, 'faena_id' => $item]
                );
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $fileName = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $logo->getClientOriginalExtension();
                $filePath = $logo->storeAs('empresa/' . $empresa->id . '/logo/', $fileName, 'publico');
                $empresa->logo = $fileName;
                $empresa->save();
            }
            return $this->sendResponse('success',  'Cliente creado');
        } else {
            return $this->sendError('Failed', 'Failed', 400);
        }
    }

    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        if ($empresa) {
            if($empresa->delete()) {
                return $this->sendResponse([], 'Deleted data successfully');
            }
        }
        return $this->sendError('failed to delete', 'failed to delete', 400);
    }
}