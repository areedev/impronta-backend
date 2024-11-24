<?php

namespace App\Http\Controllers;

use App\DataTables\ReporteDataTable;
use App\Models\Area;
use App\Models\Empresa;
use App\Models\Faena;
use App\Models\PerfilEvaluacion;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    function index(ReporteDataTable $dataTable)
    {
        $data['perfiles'] = PerfilEvaluacion::pluck('nombre', 'id');
        $data['empresas'] = Empresa::pluck('nombre', 'id');
        $data['faenas'] = Faena::pluck('nombre', 'id');
        $data['areas'] = Area::pluck('nombre', 'id');
        return $dataTable->render('reporte.index', $data);
    }
}
