<?php

namespace App\Http\Controllers;

use App\DataTables\FaenaDataTable;
use App\Models\Faena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FaenaDataTable $dataTable, Request $request)
    {
        return $dataTable->render('faena.index', compact('request'));
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

        $nuevo = new Faena();
        $nuevo->nombre = $request->nombre;
        $nuevo->usuario_creador = Auth::id();
        if ($nuevo->save()) {
            return back()->with('success',  'Faena creada');
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
        $faena = Faena::find($id);
        $view =  view('faena.editar', compact('faena'));
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
        $faena = Faena::find($id);
        if($faena){
            $faena->nombre = $request->nombre;
            if($faena->save()){
                return back()->with('success',  'Faena actualizada');
            }
        } else {
            return back()->withErrors(['La faena que intenta modificar no existe']);
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
        $faena = Faena::find($id);
        if ($faena) {
            $faena->delete();
            return back()->with('success',  'Faena eliminada');
        }
    }
}
