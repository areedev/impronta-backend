<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Empresa;
use App\Models\Evaluacion;
use Illuminate\Http\Request;

class BuscadorController extends Controller
{
    public function buscar(Request $request)
    {
        $searchTerm = $request->input('search');

        $candidatos = Candidato::where('nombre', 'like', "%{$searchTerm}%")
            ->orWhereHas('empresa', function ($query) use ($searchTerm) {
                $query->where('nombre', 'like', "%{$searchTerm}%");
            })
            ->get();

        $empresas = Empresa::where('nombre', 'like', "%{$searchTerm}%")
            ->get();

        $evaluaciones = Evaluacion::WhereHas('candidato', function ($query) use ($searchTerm) {
            $query->where('nombre', 'like', "%{$searchTerm}%")->orWhere('rut', 'like', "%{$searchTerm}%");
        })
            ->orWhereHas('candidato.empresa', function ($query) use ($searchTerm) {
                $query->where('nombre', 'like', "%{$searchTerm}%");
            })
            ->orWhereHas('faena', function ($query) use ($searchTerm) {
                $query->where('nombre', 'like', "%{$searchTerm}%");
            })
            ->orWhereHas('area', function ($query) use ($searchTerm) {
                $query->where('nombre', 'like', "%{$searchTerm}%");
            })
            ->get();

        $view =  view('buscador.resultados', compact('candidatos', 'empresas', 'evaluaciones'));
        return ['html' => $view->render()];
    }
}
