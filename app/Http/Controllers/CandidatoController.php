<?php

namespace App\Http\Controllers;

use App\DataTables\CandidatoDataTable;
use App\Models\Bitacora;
use App\Models\Candidato;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\Auth;

class CandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CandidatoDataTable $dataTable, Request $request)
    {
        $empresas = Empresa::pluck('nombre', 'id');
        return $dataTable->render('candidato.index', compact('request','empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'rut' => 'required|cl_rut|unique:candidatos,rut',
            'email' => 'required|email',
            'telefono' => 'required',
            'empresa' => 'sometimes|required|exists:empresas,id',
            'ci' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'licencia_municipal' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'licencia_interna' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'cv' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:3000',
        ]);
        $nuevo = new Candidato();
        if (Rut::parse($request->rut)->validate()) {
            $nuevo->rut = $request->rut;
        }
        $nuevo->nombre = $request->nombre;
        $nuevo->email = $request->email;
        $nuevo->telefono = $request->telefono;
        if(isset($request->empresa)){
            $nuevo->empresa_id = $request->empresa;
        } else {
            $nuevo->empresa_id = Auth::user()->perfil->empresa->id;
        }        
        if($nuevo->save()){
            
            $bitacora = new Bitacora();
            $bitacora->candidato_id = $nuevo->id;
            $bitacora->empresa_nueva_id = $nuevo->empresa_id;
            $bitacora->save();

            if ($request->hasFile('ci')) {
                $ci = $request->file('ci');
                $fileName = pathinfo($ci->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $ci->getClientOriginalExtension();
                $filePath = $ci->storeAs('candidatos/' . $nuevo->id . '/documentos/', $fileName, 'publico');
                $nuevo->ci = $fileName;
                $nuevo->save();
            }
            if ($request->hasFile('licencia_municipal')) {
                $licencia_municipal = $request->file('licencia_municipal');
                $fileName = pathinfo($licencia_municipal->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $licencia_municipal->getClientOriginalExtension();
                $filePath = $licencia_municipal->storeAs('candidatos/' . $nuevo->id . '/documentos/', $fileName, 'publico');
                $nuevo->licencia_municipal = $fileName;
                $nuevo->save();
            }
            if ($request->hasFile('licencia_interna')) {
                $licencia_interna = $request->file('licencia_interna');
                $fileName = pathinfo($licencia_interna->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $licencia_interna->getClientOriginalExtension();
                $filePath = $licencia_interna->storeAs('candidatos/' . $nuevo->id . '/documentos/', $fileName, 'publico');
                $nuevo->licencia_interna = $fileName;
                $nuevo->save();
            }
            if ($request->hasFile('cv')) {
                $cv = $request->file('cv');
                $fileName = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $cv->getClientOriginalExtension();
                $filePath = $cv->storeAs('candidatos/' . $nuevo->id . '/documentos/', $fileName, 'publico');
                $nuevo->cv = $fileName;
                $nuevo->save();
            }
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fileName = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $foto->getClientOriginalExtension();
                $filePath = $foto->storeAs('candidatos/' . $nuevo->id . '/foto/', $fileName, 'publico');
                $nuevo->foto = $fileName;
                $nuevo->save();
            }
            return back()->with('success',  'Candidato creado');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Candidato $candidato)
    {
        return view('candidato.ver', compact('candidato'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidato = Candidato::find($id);
        $empresas = Empresa::pluck('nombre', 'id');
        $view =  view('candidato.editar', compact('candidato','empresas'));
        return ['html' => $view->render()];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'rut' => 'required|cl_rut:unique:candidatos,rut,'.$id,
            'email' => 'required|email',
            'telefono' => 'required',
            'empresa' => 'sometimes|required|exists:empresas,id',
            'ci' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'licencia_municipal' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'licencia_interna' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'cv' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png|max:10000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:3000',
        ]);
        $candidato = Candidato::find($id);
        $empresa_antigua = $candidato->empresa_id;        
        if (Rut::parse($request->rut)->validate()) {
            $candidato->rut = $request->rut;
        }
        $candidato->nombre = $request->nombre;
        $candidato->email = $request->email;
        $candidato->telefono = $request->telefono;
        if(isset($request->empresa)){
            $candidato->empresa_id = $request->empresa;
        } else {
            $candidato->empresa_id = Auth::user()->perfil->empresa->id;
        }
        if($candidato->save()){

            if($empresa_antigua != $candidato->empresa_id){
                $bitacora = new Bitacora();
                $bitacora->candidato_id = $candidato->id;
                $bitacora->empresa_nueva_id = $candidato->empresa_id;
                $bitacora->empresa_antigua_id = $empresa_antigua;
                $bitacora->save();
            }

            if ($request->hasFile('ci')) {
                $ci = $request->file('ci');
                $fileName = pathinfo($ci->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $ci->getClientOriginalExtension();
                $filePath = $ci->storeAs('candidatos/' . $candidato->id . '/documentos/', $fileName, 'publico');
                $candidato->ci = $fileName;
                $candidato->save();
            }
            if ($request->hasFile('licencia_municipal')) {
                $licencia_municipal = $request->file('licencia_municipal');
                $fileName = pathinfo($licencia_municipal->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $licencia_municipal->getClientOriginalExtension();
                $filePath = $licencia_municipal->storeAs('candidatos/' . $candidato->id . '/documentos/', $fileName, 'publico');
                $candidato->licencia_municipal = $fileName;
                $candidato->save();
            }
            if ($request->hasFile('licencia_interna')) {
                $licencia_interna = $request->file('licencia_interna');
                $fileName = pathinfo($licencia_interna->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $licencia_interna->getClientOriginalExtension();
                $filePath = $licencia_interna->storeAs('candidatos/' . $candidato->id . '/documentos/', $fileName, 'publico');
                $candidato->licencia_interna = $fileName;
                $candidato->save();
            }
            if ($request->hasFile('cv')) {
                $cv = $request->file('cv');
                $fileName = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $cv->getClientOriginalExtension();
                $filePath = $cv->storeAs('candidatos/' . $candidato->id . '/documentos/', $fileName, 'publico');
                $candidato->cv = $fileName;
                $candidato->save();
            }
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fileName = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $foto->getClientOriginalExtension();
                $filePath = $foto->storeAs('candidatos/' . $candidato->id . '/foto/', $fileName, 'publico');
                $candidato->foto = $fileName;
                $candidato->save();
            }
            return back()->with('success',  'Candidato actualizado');
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
        $candidato = Candidato::find($id);
        if($candidato->delete()){
            return back()->with('success',  'Candidato eliminado'); 
        }
    }
}
