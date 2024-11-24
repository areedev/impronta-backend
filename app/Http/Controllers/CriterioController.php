<?php

namespace App\Http\Controllers;

use App\DataTables\CriteriosDataTable;
use App\Models\CriterioDesempeñoInterno;
use App\Models\TipoCompetencia;
use Illuminate\Http\Request;

class CriterioController extends Controller
{
    public function index(CriteriosDataTable $dataTable, Request $request)
    {
        $tipos = TipoCompetencia::pluck('abreviatura', 'id');
        return $dataTable->render('criterios.index', compact('request', 'tipos'));
    }

    function store(Request $request)
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
        if ($nuevo->save()) {
            return back()->with('success',  'Criterio creado');
        }
    }

    public function edit($id)
    {
        $criterio = CriterioDesempeñoInterno::find($id);
        $tipos = TipoCompetencia::pluck('abreviatura', 'id');
        $view =  view('criterios.editar', compact('criterio', 'tipos'));
        return ['html' => $view->render()];
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'competencia' => 'required',
            'criterio' => 'required',
            'llave' => 'required',
        ]);
        $criterio = CriterioDesempeñoInterno::find($id);
        if ($criterio) {
            $criterio->competencia_id = $request->competencia;
            $criterio->criterio = $request->criterio;
            $criterio->llave = $request->llave;
            if ($criterio->save()) {
                return back()->with('success',  'Criterio actualizado');
            }
        } else {
            return back()->withErrors(['El criterio que intenta modificar no existe']);
        }
    }

    public function destroy($id)
    {
        $criterio = CriterioDesempeñoInterno::find($id);
        if ($criterio) {
            $criterio->delete();
            return back()->with('success', 'Criterio eliminado');
        }
    }
}
