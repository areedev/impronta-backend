<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use App\Models\Bitacora;
use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\Evaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\DB;

class CandidateController extends BaseApiController
{
    public function index()
    {
        $candidates = Candidato::select('c.*', 'e.id as empresa_id', 'e.nombre as empresa_name')
        ->from('candidatos as c')
        ->leftJoin('empresas as e', 'c.empresa_id', '=', 'e.id')->get();
        $empresas = Empresa::get();
        return $this->sendResponse(['candidates' => $candidates, 'empresas' => $empresas], 'Fetched data successfully');
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
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'rut' => 'required|unique:candidatos,rut, '.$request->id,
            'email' => 'required|email',
            'telefono' => 'required',
            'empresa' => 'sometimes|required|exists:empresas,id',
            'ci' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'licencia_municipal' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'licencia_interna' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'cv' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:3000',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }
        $candidate = Candidato::find($request->id);
        $save = false;
        if ($candidate == null) {
            if ($request->id > -1)
                return $this->sendError('Candidate not found.', 'Candidate not found.', 404);
            else
                $candidate = new Candidato();
        } else {
            $empresa_antigua = $candidate->empresa_id;
            $save = true;
        }
        // if (Rut::parse($request->rut)->validate()) {
        //     $nuevo->rut = $request->rut;
        // }
        $candidate->rut = $request->rut;
        $candidate->nombre = $request->nombre;
        $candidate->email = $request->email;
        $candidate->telefono = $request->telefono;
        if(isset($request->empresa)){
            $candidate->empresa_id = $request->empresa;
        } else {
            $candidate->empresa_id = Auth::user()->perfil->empresa->id;
        }
        if($candidate->save()){
            
            if (!$save) {
                $bitacora = new Bitacora();
                $bitacora->candidato_id = $candidate->id;
                $bitacora->empresa_nueva_id = $candidate->empresa_id;
                $bitacora->save();
            } else {
                if($empresa_antigua != $candidate->empresa_id){
                    $bitacora = new Bitacora();
                    $bitacora->candidato_id = $candidate->id;
                    $bitacora->empresa_nueva_id = $candidate->empresa_id;
                    $bitacora->empresa_antigua_id = $empresa_antigua;
                    $bitacora->save();
                }
            }

            if ($request->hasFile('ci')) {
                $ci = $request->file('ci');
                $fileName = pathinfo($ci->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $ci->getClientOriginalExtension();
                $filePath = $ci->storeAs('candidatos/' . $candidate->id . '/documentos/', $fileName, 'publico');
                $candidate->ci = $fileName;
                $candidate->save();
            }
            if ($request->hasFile('licencia_municipal')) {
                $licencia_municipal = $request->file('licencia_municipal');
                $fileName = pathinfo($licencia_municipal->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $licencia_municipal->getClientOriginalExtension();
                $filePath = $licencia_municipal->storeAs('candidatos/' . $candidate->id . '/documentos/', $fileName, 'publico');
                $candidate->licencia_municipal = $fileName;
                $candidate->save();
            }
            if ($request->hasFile('licencia_interna')) {
                $licencia_interna = $request->file('licencia_interna');
                $fileName = pathinfo($licencia_interna->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $licencia_interna->getClientOriginalExtension();
                $filePath = $licencia_interna->storeAs('candidatos/' . $candidate->id . '/documentos/', $fileName, 'publico');
                $candidate->licencia_interna = $fileName;
                $candidate->save();
            }
            if ($request->hasFile('cv')) {
                $cv = $request->file('cv');
                $fileName = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $cv->getClientOriginalExtension();
                $filePath = $cv->storeAs('candidatos/' . $candidate->id . '/documentos/', $fileName, 'publico');
                $candidate->cv = $fileName;
                $candidate->save();
            }
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fileName = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $foto->getClientOriginalExtension();
                $filePath = $foto->storeAs('candidatos/' . $candidate->id . '/foto/', $fileName, 'publico');
                $candidate->foto = $fileName;
                $candidate->save();
            }
            return $this->sendResponse([], 'Saved data successfully');
        } else {
            return $this->sendError('failed to save candidate', 'failed to save candidate', 400);
        }
    }
    public function destroy($id)
    {
        $candidato = Candidato::find($id);
        if($candidato->delete()){
            return $this->sendResponse([], 'Deleted data successfully');
        } else {
            return $this->sendError('failed to delete candidate', 'failed to delete candidate', 400);
        }
    }
}