<?php

namespace App\Http\Controllers;

use App\DataTables\ItemPerfilEvaluacionDataTable;
use App\Models\ItemPerfilEvaluacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ItemPerfilEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemPerfilEvaluacionDataTable $dataTable, Request $request)
    {
        return $dataTable->render('itemperfilevaluacion.index', compact('request'));
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

        $nuevo = new ItemPerfilEvaluacion();
        $nuevo->nombre = $request->nombre;
        $nuevo->usuario_creador = Auth::id();
        if ($nuevo->save()) {
            return back()->with('success',  'Item creado');
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
        $item = ItemPerfilEvaluacion::find($id);
        $view =  view('itemperfilevaluacion.editar', compact('item'));
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
        $item = ItemPerfilEvaluacion::find($id);
        if($item){
            $item->nombre = $request->nombre;
            if($item->save()){
                return back()->with('success',  'Item actualizado');
            }
        } else {
            return back()->withErrors(['El item que intenta modificar no existe']);
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
        $item = ItemPerfilEvaluacion::find($id);
        if ($item) {
            $item->delete();
            return back()->with('success',  'Item eliminado');
        }
    }
}
