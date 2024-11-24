<?php

namespace App\Http\Controllers;

use App\DataTables\AreaDataTable;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AreaDataTable $dataTable, Request $request)
    {
        return $dataTable->render('area.index', compact('request'));
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
        ]);

        $nuevo = new Area();
        $nuevo->nombre = $request->nombre;
        $nuevo->usuario_creador = Auth::id();
        if ($nuevo->save()) {
            return back()->with('success',  'Area creada');
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
        $area = Area::find($id);
        $view =  view('area.editar', compact('area'));
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
        ]);
        $area = Area::find($id);
        if ($area) {
            $area->nombre = $request->nombre;
            if ($area->save()) {
                return back()->with('success',  'Area actualizada');
            }
        } else {
            return back()->withErrors(['El area que intenta modificar no existe']);
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
        $area = Area::find($id);
        if ($area) {
            $area->delete();
            return back()->with('success',  'Area eliminada');
        }
    }
}
