<?php

namespace App\Http\Controllers;

use App\DataTables\EvaluacionDataTable;
use App\Models\Aprobacion;
use App\Models\Candidato;
use App\Models\CriterioDesempeñoInternoEvaluacion;
use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\EvaluacionTeorica;
use App\Models\Faena;
use App\Models\ItemEvaluacionTeorica;
use App\Models\PerfilEvaluacion;
use App\Models\ResultadoEvaluacion;
use App\Models\TipoCompetencia;
use App\Models\User;
use App\Notifications\NotificacionGeneral;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Eval_;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EvaluacionController extends Controller
{
    public function index(EvaluacionDataTable $dataTable, Request $request)
    {
        return $dataTable->render('evaluaciones.index');
    }

    public function create()
    {
        $data['perfiles'] = PerfilEvaluacion::pluck('nombre', 'id');
        $data['empresas'] = Empresa::pluck('nombre', 'id');
        return view('evaluaciones.crear', $data);
    }

    function show($id)
    {
        $data['perfiles'] = PerfilEvaluacion::pluck('nombre', 'id');
        $data['empresas'] = Empresa::pluck('nombre', 'id');
        $data['evaluacion'] = Evaluacion::find($id);
        return view('evaluaciones.ver', $data);
    }

    function validar(Request $request)
    {
        $this->validate($request, [
            'rut' => 'required',
        ]);
        $candidato = Candidato::where('rut', $request->rut)->first();
        if ($candidato) {
            $id = $candidato->empresa_id;
            $empresa = Empresa::find($id);
            $data['empresa'] = array($empresa->id => $empresa->nombre);
            $faenas = $empresa->faenas;
            $areas = $empresa->areas;
            $faenas = $faenas->pluck('faena.nombre', 'faena_id');
            $areas = $areas->pluck('area.nombre', 'area_id');
            $data['candidato'] = $candidato;
            $data['faenas'] = $faenas;
            $data['areas'] = $areas;
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        return response()->json($data);
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'rut' => 'required|exists:candidatos,rut',
            'perfil_evaluacion' => 'required|exists:perfil_evaluaciones,id',
            'cargo' => 'required',
            'evaluador' => 'required',
            'empresa' => 'required|exists:empresas,id',
            'faena' => 'required|exists:faenas,id',
            'area' => 'required|exists:areas,id',
        ]);
        $candidato = Candidato::where('rut', $request->rut)->first();
        $nuevo = new Evaluacion;
        $nuevo->candidato_id = $candidato->id;
        $nuevo->empresa_id  = $candidato->empresa_id;
        $nuevo->faena_id  = $request->faena;
        $nuevo->area_id  = $request->area;
        $nuevo->perfil_evaluacion_id = $request->perfil_evaluacion;
        $nuevo->cargo  = $request->cargo;
        $nuevo->evaluador_asignado  = $request->evaluador;
        $nuevo->fecha_solicitud = $request->fecha_solicitud;
        $nuevo->fecha_ejecucion = $request->fecha_ejecucion;
        $nuevo->fecha_emision  = $request->fecha_emision;
        $nuevo->certificado  = $request->certificado;
        $nuevo->equipo  = $request->equipo;
        $nuevo->marca  = $request->marca;
        $nuevo->modelo  = $request->modelo;
        $nuevo->year  = $request->year;
        $nuevo->usuario_creador = Auth::id();
        if ($nuevo->save()) {
            if ($request->hasFile('condiciones')) {
                $condiciones = $request->file('condiciones');
                $fileName = pathinfo($condiciones->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $condiciones->getClientOriginalExtension();
                $filePath = $condiciones->storeAs('evaluacion/' . $nuevo->id . '/condiciones/', $fileName, 'publico');
                $nuevo->condiciones = $fileName;
                $nuevo->save();
            }
            $notificacion = [
                'notificacion' => 'Se he creado una nueva evaluación para ' . $nuevo->candidato->nombre . ' con el perfil ' . $nuevo->perfilEvaluacion->nombre . '.',
                'url' => route('evaluaciones.show', $nuevo->id)
            ];
            $usuariosNot = User::where('notificaciones', true)->get();
            foreach ($usuariosNot as $usuariosNotificacion) {
                $usuariosNotificacion->notify(new NotificacionGeneral($notificacion));
            }
            return redirect()->route('evaluaciones.practica', $nuevo->id);
        }
    }

    function practica($id)
    {
        $evaluacion = Evaluacion::find($id);
        return view('evaluaciones.practica', compact('evaluacion'));
    }

    function notas(Request $request, $id)
    {

        $this->validate($request, [
            'nota' => 'required|array|numeric_array',
            'nota.*' => 'max_decimal',
            'archivo_comentario.*' => 'nullable|image|mimes:jpeg,png,gif,bmp',
            'archivo_comentario_criterio.*.*' => 'nullable|image|mimes:jpeg,png,gif,bmp',
        ]);

        foreach ($request->nota as $key => $nota) {
            $nota = str_replace(',', '.', $nota);
            $resultado = ResultadoEvaluacion::updateOrCreate(
                ['evaluacion_id' => $id, 'item_id' => $key],
                ['nota' => $nota, 'porcentaje' => number_format(($nota / 4) * 100, 2), 'comentario' => $request->comentario[$key] ?: null]
            );
            if ($request->hasFile('archivo_comentario')) {
                if (!empty($request->file('archivo_comentario')[$key])) {
                    $archivo = $request->file('archivo_comentario')[$key];
                    $fileName = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                    $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                    $fileName = time() . '_' . $fileName . '.' . $archivo->getClientOriginalExtension();
                    $filePath = $archivo->storeAs('evaluacion/resultados/' . $resultado->id . '/', $fileName, 'publico');
                    $resultado->archivo = $fileName;
                    $resultado->save();
                }
            }
            if (isset($request->calificacion_criterio[$key])) {
                foreach ($request->calificacion_criterio[$key] as $keycriterio => $criterio) {
                    $criterioup = CriterioDesempeñoInternoEvaluacion::updateOrCreate(
                        ['evaluacion_id' => $id, 'criterio_id' => $keycriterio],
                        ['evaluacion_id' => $id, 'criterio_id' => $keycriterio, 'nota' => str_replace(',', '.', $request->calificacion_criterio[$key][$keycriterio]), 'comentarios' => $request->comentario_criterio[$key][$keycriterio]]
                    );
                    if (!empty($request->file('archivo_comentario_criterio')[$key][$keycriterio])) {
                        $archivo = $request->file('archivo_comentario_criterio')[$key][$keycriterio];
                        $fileName = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                        $fileName = time() . '_' . $fileName . '.' . $archivo->getClientOriginalExtension();
                        $filePath = $archivo->storeAs('evaluacion/resultados/criterios/' . $criterioup->id . '/', $fileName, 'publico');
                        $criterioup->archivo = $fileName;
                        $criterioup->save();
                    }
                }
            }
        }

        $evaluacion = Evaluacion::find($id);
        if ($evaluacion->estado <= 1) {
            $evaluacion->estado = 1;
            $evaluacion->save();
        }

        $this->aprobacion($id);

        $notificacion = [
            'notificacion' => 'Se asignaron calificaciones a la evaluación #' . $id . '.',
            'url' => route('evaluaciones.show', $id)
        ];
        $usuariosNot = User::where('notificaciones', true)->get();
        foreach ($usuariosNot as $usuariosNotificacion) {
            $usuariosNotificacion->notify(new NotificacionGeneral($notificacion));
        }

        return redirect()->route('evaluaciones.comentarios', $id)->with('success',  'Datos guardados');
    }

    function aprobacion($id)
    {
        $evaluacion = Evaluacion::find($id);
        $existe = Aprobacion::where('evaluacion_id', $id)->get()->first();
        if ($existe) {
            $aprobacion = $existe;
        } else {
            $aprobacion = new Aprobacion();
        }
        $aprobacion->estado = 1;
        $aprobacion->evaluacion_id = $id;
        $porcentaje_practica = $evaluacion->porcentaje_practica;
        //comprobamos porcentaje evaluacion practica
        if ($porcentaje_practica < 75) {
            $aprobacion->estado = 0;
        }

        //comprobamos brechas teoricas
        $brechas = ResultadoEvaluacion::with(['itemPerfilEvaluacion', 'item', 'evaluacion.perfilEvaluacion.secciones.items'])->whereHas('evaluacion.perfilEvaluacion.secciones.items.competencia.tipo', function ($query) {
            $query->whereIn('abreviatura', ['CCC', 'CCCF']);
        })->where('nota', '<', 3.00)->where('evaluacion_id', $id)->get();

        if ($brechas->isNotEmpty()) {
            $competenciaIds = [];
            foreach ($brechas as $brecha) {
                if (isset($brecha->item->competencia_id)) {
                    $competenciaIds[] = $brecha->item->competencia_id;
                }
            }
            $aprobacion->estado = 0;
            $aprobacion->brechas_criticas = implode(',', $competenciaIds);
        }

        //comprobamos nota final
        if ($evaluacion->resultado->isNotEmpty() && isset($evaluacion->teorica->id)) {
            $nota = $evaluacion->nota_total + $evaluacion->teorica->nota_total;
            $porcentaje = $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total;
            if ($porcentaje < 80) {
                $aprobacion->estado = 0;
            }
            $aprobacion->nota = $nota;
            $aprobacion->porcentaje = $evaluacion->porcentaje_total + $evaluacion->teorica->porcentaje_total;
        }

        $aprobacion->save();
    }

    function comentarios($id)
    {
        $evaluacion = Evaluacion::find($id);
        return view('evaluaciones.resultado', compact('evaluacion'));
    }
    function comentarios_post(Request $request, $id)
    {
        $evaluacion = Evaluacion::find($id);
        $evaluacion->comentarios = $request->comentarios;
        $evaluacion->estado = $request->estado_evaluacion;
        if ($evaluacion->save()) {
            if ($request->hasFile('firma_evaluador')) {
                $firma_evaluador = $request->file('firma_evaluador');
                $fileName = pathinfo($firma_evaluador->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $firma_evaluador->getClientOriginalExtension();
                $filePath = $firma_evaluador->storeAs('evaluacion/' . $evaluacion->id . '/firmas/', $fileName, 'publico');
                $evaluacion->firma_evaluador = $fileName;
                $evaluacion->save();
            }
            if ($request->hasFile('firma_supervisor')) {
                $firma_supervisor = $request->file('firma_supervisor');
                $fileName = pathinfo($firma_supervisor->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $firma_supervisor->getClientOriginalExtension();
                $filePath = $firma_supervisor->storeAs('evaluacion/' . $evaluacion->id . '/firmas/', $fileName, 'publico');
                $evaluacion->firma_supervisor = $fileName;
                $evaluacion->save();
            }
        }
        return redirect()->route('evaluaciones.index')->with('success',  'Datos guardados');
    }

    public function destroy($id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            $evaluacion->delete();
            return back()->with('success',  'Evaluación eliminada');
        }
    }

    function teorica(Request $request, $id)
    {
        $existe = EvaluacionTeorica::where('evaluacion_id', $id)->get()->first();
        if ($existe) {
            $teorica = $existe;
            $evaluacion = Evaluacion::find($id);
            $tipos = TipoCompetencia::pluck('abreviatura', 'id');
            return view('evaluaciones_teoricas.editar', compact('tipos', 'evaluacion', 'teorica'));
        } else {
            $evaluacion = Evaluacion::find($id);
            $tipos = TipoCompetencia::pluck('abreviatura', 'id');
            return view('evaluaciones_teoricas.crear', compact('tipos', 'evaluacion'));
        }
    }

    function nueva_pregunta()
    {
        $random = rand(100, 5000);
        $random2 = rand(100, 5000);
        $random3 = rand(100, 5000);
        $tipos = TipoCompetencia::pluck('abreviatura', 'id');
        $view =  view('evaluaciones_teoricas.pregunta', compact('tipos', 'random', 'random2', 'random3'));
        return ['html' => $view->render(), 'random' => $random];
    }

    function teorica_store(Request $request, $id)
    {

        /*foreach ($request->competencia as $llavecompetencia => $competencia) {

            echo $competencia . ', ' . (isset($request->pregunta[$llavecompetencia]) ? $request->pregunta[$llavecompetencia] : 'nada') . ', ' . (isset($request->comentario[$llavecompetencia]) ? $request->comentario[$llavecompetencia] : 'nada') . '<br>';
        }
        return;*/

        $this->validate($request, [
            'preguntas' => 'required|integer',
            'preguntas_buenas' => 'required|integer',
            'nota' => 'required|max_decimal',
            'pregunta' => 'required',
            'competencia.*' => 'required',
            'archivo' => 'required|mimes:doc,docx,xls,xlsx,ppt,pptx,pdf,jpeg,png,gif,bmp',
        ]);

        $teorica = new EvaluacionTeorica();
        $teorica->evaluacion_id = $id;
        $teorica->preguntas = $request->preguntas;
        $teorica->preguntas_buenas = $request->preguntas_buenas;
        $nota = str_replace(',', '.', $request->nota);
        $teorica->nota = $nota;
        if ($teorica->save()) {
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $fileName = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $archivo->getClientOriginalExtension();
                $filePath = $archivo->storeAs('evaluacion/' . $id . '/teorica/', $fileName, 'publico');
                $teorica->archivo = $fileName;
                $teorica->save();
            }
            foreach ($request->competencia as $llavecompetencia => $competencia) {
                $item = new ItemEvaluacionTeorica();
                $item->evaluacion_id = $id;
                $item->competencia_id = $competencia;
                $item->pregunta = isset($request->pregunta[$llavecompetencia]) ? $request->pregunta[$llavecompetencia] : null;
                $item->comentario = isset($request->comentario[$llavecompetencia]) ? $request->comentario[$llavecompetencia] : null;
                $item->save();
            }
            $this->aprobacion($id);
            $notificacion = [
                'notificacion' => 'Se asigno una evaluación teorica a la evaluación #' . $id . '.',
                'url' => route('evaluaciones.show', $id)
            ];
            $usuariosNot = User::where('notificaciones', true)->get();
            foreach ($usuariosNot as $usuariosNotificacion) {
                $usuariosNotificacion->notify(new NotificacionGeneral($notificacion));
            }
            return redirect()->route('evaluaciones.resultados', $id)->with('success',  'Datos guardados');
        } else {
        }
    }

    function teorica_update(Request $request, $id)
    {
        $this->validate($request, [
            'preguntas' => 'required|integer',
            'preguntas_buenas' => 'required|integer',
            'nota' => 'required|max_decimal',
            'pregunta' => 'required',
            'competencia.*' => 'required',
            'archivo' => 'nullabe|mimes:doc,docx,xls,xlsx,ppt,pptx,pdf,jpeg,png,gif,bmp',
        ]);

        $teorica = EvaluacionTeorica::where('evaluacion_id', $id)->get()->first();
        $teorica->evaluacion_id = $id;
        $teorica->preguntas = $request->preguntas;
        $teorica->preguntas_buenas = $request->preguntas_buenas;
        $nota = str_replace(',', '.', $request->nota);
        $teorica->nota = $nota;
        if ($teorica->save()) {
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $fileName = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $archivo->getClientOriginalExtension();
                $filePath = $archivo->storeAs('evaluacion/' . $id . '/teorica/', $fileName, 'publico');
                $teorica->archivo = $fileName;
                $teorica->save();
            }
            $claves = array_keys($request->competencia);
            ItemEvaluacionTeorica::whereNotIn('competencia_id', $claves)->where('evaluacion_id', $id)->delete();
            foreach ($request->competencia as $llavecompetencia => $competencia) {
                ItemEvaluacionTeorica::updateOrCreate(
                    ['evaluacion_id' => $id, 'competencia_id' => $competencia],
                    ['evaluacion_id' => $id, 'competencia_id' => isset($request->competencia[$llavecompetencia]) ? $request->competencia[$llavecompetencia] : null, 'pregunta' => isset($request->pregunta[$llavecompetencia]) ? $request->pregunta[$llavecompetencia] : null, 'comentario' => isset($request->comentario[$llavecompetencia]) ? $request->comentario[$llavecompetencia] : null]
                );
            }
            return redirect()->route('evaluaciones.resultados', $id)->with('success',  'Datos guardados');
        } else {
        }
    }

    function resultados($id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            $tipos = TipoCompetencia::pluck('abreviatura', 'id');
            return view('evaluaciones.resultados', compact('tipos', 'evaluacion'));
        } else {
            return redirect('404');
        }
    }

    public function pdf($id)
    {
        $encryptedId = Crypt::encrypt($id);
        $url = route('pdfpublico', $encryptedId);
        $qr = QrCode::size(150)->generate($url);
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qr);
        $data['perfiles'] = PerfilEvaluacion::pluck('nombre', 'id');
        $data['empresas'] = Empresa::pluck('nombre', 'id');
        $data['evaluacion'] = Evaluacion::find($id);
        $data['qr'] = $qrCodeBase64;
        $pdf = Pdf::loadView('evaluaciones.pdf', $data);
        return $pdf->stream('' . $id . '.pdf');
    }

    public function public_pdf($id)
    {
        $decryptedId = Crypt::decrypt($id);
        $url = route('pdfpublico', $id);
        $qr = QrCode::size(150)->generate($url);
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qr);
        $data['perfiles'] = PerfilEvaluacion::pluck('nombre', 'id');
        $data['empresas'] = Empresa::pluck('nombre', 'id');
        $data['evaluacion'] = Evaluacion::find($decryptedId);
        $data['qr'] = $qrCodeBase64;
        $pdf = Pdf::loadView('evaluaciones.pdf', $data);
        return $pdf->stream('' . $id . '.pdf');
    }

    function actualizar_estado(Request $request, $id)
    {
        $this->validate($request, [
            'estado_evaluacion' => 'required|in:0,1,2',
        ]);

        $evaluacion = Evaluacion::find($id);
        $evaluacion->estado = $request->estado_evaluacion;
        if ($evaluacion->save()) {
            return back()->with('success',  'Estado de evaluación actualizado');
        } else {
            return back();
        }
    }

    function actualizar_informacion(Request $request, $id)
    {
        $this->validate($request, [
            'faena' => 'required|exists:faenas,id',
            'area' => 'required|exists:areas,id',
        ]);

        $evaluacion = Evaluacion::find($id);
        $evaluacion->faena_id  = $request->faena;
        $evaluacion->area_id  = $request->area;
        $evaluacion->fecha_solicitud = $request->fecha_solicitud;
        $evaluacion->fecha_ejecucion = $request->fecha_ejecucion;
        $evaluacion->fecha_emision  = $request->fecha_emision;
        $evaluacion->certificado  = $request->certificado;
        $evaluacion->equipo  = $request->equipo;
        $evaluacion->marca  = $request->marca;
        $evaluacion->modelo  = $request->modelo;
        $evaluacion->year  = $request->year;
        if ($evaluacion->save()) {
            if ($request->hasFile('condiciones')) {
                $condiciones = $request->file('condiciones');
                $fileName = pathinfo($condiciones->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
                $fileName = time() . '_' . $fileName . '.' . $condiciones->getClientOriginalExtension();
                $filePath = $condiciones->storeAs('evaluacion/' . $evaluacion->id . '/condiciones/', $fileName, 'publico');
                $evaluacion->condiciones = $fileName;
                $evaluacion->save();
            }
            return back()->with('success',  'Información de evaluación actualizado');
        } else {
            return back();
        }
    }
}
