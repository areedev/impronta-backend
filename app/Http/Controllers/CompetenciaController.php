<?php

namespace App\Http\Controllers;

use App\DataTables\CompetenciaDataTable;
use App\Models\Competencia;
use App\Models\TipoCompetencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetenciaController extends Controller
{
    public function index(CompetenciaDataTable $dataTable, Request $request)
    {
        $tipos = TipoCompetencia::pluck('abreviatura', 'id');
        return $dataTable->render('competencia.index', compact('request', 'tipos'));
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
        if ($nuevo->save()) {
            return back()->with('success',  'Competencia creada');
        }
    }

    public function edit($id)
    {
        $competencia = Competencia::find($id);
        $tipos = TipoCompetencia::pluck('abreviatura', 'id');
        $view =  view('competencia.editar', compact('competencia', 'tipos'));
        return ['html' => $view->render()];
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
            if ($competencia->save()) {
                return back()->with('success',  'Competencia actualizada');
            }
        } else {
            return back()->withErrors(['La competencia que intenta modificar no existe']);
        }
    }

    public function destroy($id)
    {
        $competencia = Competencia::find($id);
        if ($competencia) {
            $competencia->delete();
            return back()->with('success',  'Competencia eliminada');
        }
    }
}
