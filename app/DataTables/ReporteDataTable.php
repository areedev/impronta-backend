<?php

namespace App\DataTables;

use App\Models\Aprobacion;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReporteDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('evaluacion.created_at', function (Aprobacion $aprobacion) {
                return $aprobacion->evaluacion->created_at->format('d-m-Y h:i');
            })
            ->editColumn('evaluacion.perfilEvaluacion.nombre', function (Aprobacion $aprobacion) {
                return $aprobacion->evaluacion->perfilEvaluacion->nombre;
            })
            ->editColumn('reporte', function (Aprobacion $aprobacion) {
                return '<a class="btn btn-primary" href="'.URL::to('evaluaciones').'/pdf/'.$aprobacion->evaluacion->id.'" target="_blank">Ver Informe</a>';
            })
            ->editColumn('evaluacion.estado', function (Aprobacion $aprobacion) {
                if ($aprobacion->evaluacion->estado == 2) {
                    return '<span class="mb-1 badge text-bg-success text-dark">COMPLETADO</span>';
                } elseif ($aprobacion->evaluacion->estado == 1) {
                    return '<span class="mb-1 badge text-bg-info">EN PROCESO</span>';
                } elseif ($aprobacion->evaluacion->estado == 3) {
                    return '<span class="mb-1 badge text-bg-danger">RECHAZADO</span>';
                } else {
                    return '<span class="mb-1 badge text-bg-warning">EN ESPERA</span>';
                }
            })
            ->editColumn('estado', function (Aprobacion $aprobacion) {
                if ($aprobacion->estado == 1) {
                    return '<span class="mb-1 badge text-bg-success text-dark">ACREDITADO</span>';
                } else {
                    return '<span class="mb-1 badge text-bg-danger">NO ACREDITADO</span>';
                }
            })
            ->rawColumns(['evaluacion.estado', 'estado', 'reporte'])
            ->setRowId('evaluacion.id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Reporte $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Aprobacion $model): QueryBuilder
    {
        $perfil = $this->request->get('perfil');
        $empresa = $this->request->get('empresa');
        $area = $this->request->get('area');
        $faena = $this->request->get('faena');
        $estado = $this->request->get('estado');
        $aprobacion = $this->request->get('aprobacion');
        return $model->newQuery()->with(['evaluacion', 'evaluacion.candidato', 'evaluacion.empresa', 'evaluacion.faena', 'evaluacion.area', 'evaluacion.perfilEvaluacion', 'evaluacion.teorica'])->select('aprobaciones.*')
            ->when($perfil != '', function ($query) use ($perfil) {
                return $query->whereRelation('evaluacion', 'perfil_evaluacion_id', $perfil);
            })
            ->when($empresa != '', function ($query) use ($empresa) {
                return $query->whereRelation('evaluacion', 'empresa_id', $empresa);
            })
            ->when($area != '', function ($query) use ($area) {
                return $query->whereRelation('evaluacion', 'area_id', $area);
            })
            ->when($faena != '', function ($query) use ($faena) {
                return $query->whereRelation('evaluacion', 'faena_id', $faena);
            })
            ->when($estado != '', function ($query) use ($estado) {
                return $query->whereRelation('evaluacion', 'estado', $estado);
            })
            ->when($aprobacion != '', function ($query) use ($aprobacion) {
                return $query->where('aprobaciones.estado', $aprobacion);
            })
            ->when(!Auth::user()->hasRole('administrador'), function ($query) {
                return $query->whereRelation('evaluacion', 'empresa_id', Auth::user()->perfil->empresa->id);
            });
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('reporte-table')
            ->parameters([
                'lengthMenu' => [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'Todo']
                ],
                'buttons' => [
                    'colvis',
                    [
                        'extend'  => 'excelHtml5',
                        'exportOptions' => [
                            'columns' => ':visible'
                        ],
                    ],
                    [
                        'extend'  => 'csvHtml5',
                        'exportOptions' => [
                            'columns' => ':visible'
                        ],
                    ],
                    [
                        'extend'  => 'print',
                        'exportOptions' => [
                            'columns' => ':visible'
                        ],
                    ]
                ],
            ])
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->dom(" <'row'<'col-sm-12 p-0 'B><'col-sm-6' l><'col-sm-6 p-0'f>>
            <'row'<'col-sm-12'tr>>
            <'row mt-3 '<'col-sm-5'i><'col-sm-7'p>>")
            ->orderBy(0)
            //->selectStyleSingle()
            ->language([
                'buttons' => [
                    'export' => 'Exportar',
                    'print' => 'Imprimir',
                    'excel' => 'Excel',
                    'csv' => 'CSV',
                    'colvis' => 'Ocultar Columnas',
                ],
                'lengthMenu' => 'Mostrar _MENU_ filas',
                'search' => 'Buscar',
                "loadingRecords" => "Cargando...",
                "zeroRecords" => "No se encontraron coincidencias",
                'infoEmpty' => 'No hay datos para mostrar',
                "infoFiltered" => "(Filtrado de _MAX_ total de entradas)",
                "paginate" => [
                    "first" => "Primero",
                    "last" => "Último",
                    "next" => "Siguiente",
                    "previous" => "Anterior"
                ],
                "info" => "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('evaluacion.id')->title('#'),
            Column::make('evaluacion.candidato.rut')->title('RUT Candidato'),
            Column::make('evaluacion.empresa.nombre')->title('Empresa'),
            Column::make('evaluacion.area.nombre')->title('Area'),
            Column::make('evaluacion.faena.nombre')->title('Faena'),
            Column::make('evaluacion.estado')->title('Estado'),
            Column::make('evaluacion.perfilEvaluacion.nombre')->title('Perfil'),
            Column::make('estado')->title('Aprobación'),
            Column::make('nota')->title('Nota Final'),
            Column::make('porcentaje')->title('Porcentaje Final'),
            Column::make('evaluacion.created_at')->title('Fecha Creación'),
            Column::make('reporte')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Reporte_' . date('YmdHis');
    }
}
