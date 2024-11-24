<?php

namespace App\Http\Controllers;

use App\DataTables\EmpresaDataTable;
use App\Models\Area;
use App\Models\AreaEmpresa;
use App\Models\Empresa;
use App\Models\Faena;
use App\Models\FaenaEmpresa;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Http\Request;
use Freshwork\ChileanBundle\Rut;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmpresaDataTable $dataTable, Request $request)
    {
        $areas = Area::pluck('nombre', 'id');
        $faenas = Faena::pluck('nombre', 'id');
        $usuarios = Perfil::with('usuario')->get()->pluck('nombre_completo', 'user_id');
        return $dataTable->render('empresa.index', compact('request', 'areas', 'faenas', 'usuarios'));
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
            'rut' => 'required|cl_rut',
            'contacto' => 'required',
            'usuario' => 'nullable|exist:users,id',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:3000'
        ]);

        $nuevo = new Empresa();
        if (Rut::parse($request->rut)->validate()) {
            $nuevo->rut = $request->rut;
        }
        $nuevo->user_id = $request->usuario;
        $nuevo->nombre = $request->nombre;
        $nuevo->contacto = $request->contacto;
        $nuevo->email = $request->email;
        $nuevo->telefono_contacto = $request->telefono;
        if ($nuevo->save()) {
            foreach ($request->faena as $item) {
                $faena = new FaenaEmpresa();
                $faena->empresa_id = $nuevo->id;
                $faena->faena_id = $item;
                $faena->save();
            }
            foreach ($request->area as $item) {
                $area = new AreaEmpresa();
                $area->empresa_id = $nuevo->id;
                $area->area_id = $item;
                $area->save();
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $fileName = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $logo->getClientOriginalExtension();
                $filePath = $logo->storeAs('empresa/' . $nuevo->id . '/logo/', $fileName, 'publico');
                $nuevo->logo = $fileName;
                $nuevo->save();
            }
            return back()->with('success',  'Cliente creado');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa = Empresa::find($id);
        $areas = Area::pluck('nombre', 'id');
        $faenas = Faena::pluck('nombre', 'id');
        $usuarios = User::pluck('email', 'id');
        $view =  view('empresa.editar', compact('empresa', 'areas', 'faenas', 'usuarios'));
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
            'rut' => 'required|cl_rut',
            'contacto' => 'required',
            'usuario' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:3000'
        ]);

        $empresa = Empresa::find($id);
        if ($empresa) {
            if (Rut::parse($request->rut)->validate()) {
                $empresa->rut = $request->rut;
            }
            $empresa->user_id = $request->usuario;
            $empresa->nombre = $request->nombre;
            $empresa->contacto = $request->contacto;
            $empresa->email = $request->email;
            $empresa->telefono_contacto = $request->telefono;
            if ($empresa->save()) {
                AreaEmpresa::whereNotIn('area_id', $request->area)->where('empresa_id', $empresa->id)->delete();
                FaenaEmpresa::whereNotIn('faena_id', $request->area)->where('empresa_id', $empresa->id)->delete();
                foreach ($request->area as $item) {
                    AreaEmpresa::updateOrInsert(
                        ['empresa_id' => $empresa->id, 'area_id' => $item],
                        ['empresa_id' => $empresa->id, 'area_id' => $item]
                    );
                }
                foreach ($request->faena as $item) {
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
                return back()->with('success',  'Cliente actualizado');
            }
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
        $empresa = Empresa::find($id);
        if ($empresa) {
            $empresa->delete();
            return back()->with('success',  'Cliente eliminado');
        }
    }
}
