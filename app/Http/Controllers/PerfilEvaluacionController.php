<?php

namespace App\Http\Controllers;

use App\DataTables\PerfilEvaluacionDataTable;
use App\Models\Competencia;
use App\Models\ItemPerfilEvaluacion;
use App\Models\ItemSeccionPerfilEvaluacion;
use App\Models\PerfilEvaluacion;
use App\Models\SeccionPerfilEvaluacion;
use App\Models\TipoCompetencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PerfilEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PerfilEvaluacionDataTable $dataTable, Request $request)
    {
        return $dataTable->render('perfilevaluacion.index', compact('request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perfilevaluacion.crear');
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

        $nuevo = new PerfilEvaluacion();
        $nuevo->nombre = $request->nombre;
        $nuevo->usuario_creador = Auth::id();
        if ($nuevo->save()) {
            $seccion = new SeccionPerfilEvaluacion();
            $seccion->perfil_evaluacion_id = $nuevo->id;
            $seccion->save();
            return redirect()->route('perfilevaluaciones.edit', $nuevo->id);
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
        $perfil = PerfilEvaluacion::find($id);
        $items = ItemPerfilEvaluacion::pluck('nombre', 'id');
        $tipos = TipoCompetencia::pluck('abreviatura','id');
        return view('perfilevaluacion.editar', compact('perfil', 'items', 'tipos'));
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
            'nombre_seccion' => 'required'
        ]);
        $perfil = PerfilEvaluacion::find($id);
        if ($perfil) {
            $perfil->nombre = $request->nombre;
            if ($perfil->save()) {

                $orden = 1;
                foreach ($request->nombre_seccion as $llaveseccion => $seccion) {
                    SeccionPerfilEvaluacion::updateOrInsert(
                        ['id' => $llaveseccion],
                        ['nombre' => $seccion, 'orden' => $orden]
                    );
                    if(isset($request->competencia[$llaveseccion])){
                        foreach ($request->competencia[$llaveseccion] as $llaveitem => $item) {
                            if($item != ''){
                                ItemSeccionPerfilEvaluacion::updateOrInsert(
                                    ['id' => $llaveitem, 'seccion_id' => $llaveseccion],
                                    ['competencia_id' => $item]
                                );
                             } else {
                                ItemSeccionPerfilEvaluacion::find($llaveitem)->delete();
                             }
                        }
                    }
                    $orden++;
                }

                return back()->with('success',  'Perfil actualizado');
            }
        } else {
            return back()->withErrors(['El perfil que intenta modificar no existe']);
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
        $perfil = PerfilEvaluacion::find($id);
        if ($perfil) {
            $perfil->delete();
            return back()->with('success',  'Perfil eliminado');
        }
    }

    function nueva_columna(Request $request)
    {
        $this->validate($request, [
            'perfil' => 'required',
            'seccion' => 'required',
        ]);
        $item = new ItemSeccionPerfilEvaluacion();
        $item->seccion_id = $request->seccion;
        if ($item->save()) {
            $items = ItemPerfilEvaluacion::pluck('nombre', 'id');
            $tipos = TipoCompetencia::pluck('abreviatura','id');
            $seccion = $request->seccion;
            $view =  view('perfilevaluacion.columna', compact('items', 'item', 'tipos'));
            return ['html' => $view->render()];
        }
    }

    function competencia(Request $request){
        $this->validate($request, [
            'tipo' => 'required',
        ]);
        $search = $request->search;
        $id = $request->tipo;
        if ($search == '') {
            $items = Competencia::orderby('nombre', 'asc')->where('tipo_competencia_id', $id)->select('id', 'nombre')->get();
        } else {
            $items = Competencia::orderby('nombre', 'asc')->select('id', 'nombre')->where('tipo_competencia_id', $id)->where('nombre', 'like', '%' . $search . '%')->get();
        }

        $response = array();
        foreach ($items as $item) {
            $response[] = array(
                "id" => $item->id,
                "text" => $item->nombre
            );
        }
        return response()->json($response);
    }

    function descripcion(Request $request)
    {
        $this->validate($request, [
            'competencia' => 'required',
        ]);
        $competencia = Competencia::find($request->competencia);
        if ($competencia) {
            $data = [
                "status" => true,
                'definicion' => $competencia->definicion
            ];
            return response()->json($data);
        }
    }

    function eliminar_columna(Request $request)
    {
        $this->validate($request, [
            'item' => 'required',
        ]);
        $item = ItemSeccionPerfilEvaluacion::find($request->item);
        if ($item) {
            $item->delete();
            $data = [
                "status" => true,
            ];
            return response()->json($data);
        }
    }

    function nueva_seccion(Request $request)
    {
        $this->validate($request, [
            'perfil' => 'required',
        ]);
        $lastseccion = SeccionPerfilEvaluacion::where('perfil_evaluacion_id', $request->perfil)->latest()->first();
        $seccion = new SeccionPerfilEvaluacion();
        $seccion->perfil_evaluacion_id = $request->perfil;
        $seccion->orden = $lastseccion->orden + 1;
        if ($seccion->save()) {
            $view =  view('perfilevaluacion.seccion', compact('seccion'));
            return ['html' => $view->render()];
        }
    }

    function eliminar_seccion(Request $request)
    {
        $this->validate($request, [
            'seccion' => 'required',
        ]);
        $seccion = SeccionPerfilEvaluacion::find($request->seccion);
        if ($seccion) {
            $seccion->delete();
            $data = [
                "status" => true,
            ];
            return response()->json($data);
        }
    }
}
