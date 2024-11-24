<?php

namespace App\DataTables;

use App\Models\Evaluacion;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class EvaluacionDataTable extends DataTable
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
            ->addColumn('acciones', function (Evaluacion $evaluacion) {
                return view('evaluaciones.acciones', compact('evaluacion'));
            })
            ->addColumn('estado', function (Evaluacion $evaluacion) {
                if ($evaluacion->estado == 2) {
                    return '<span class="mb-1 badge text-bg-success text-dark">COMPLETADO</span>';
                } elseif ($evaluacion->estado == 1) {
                    return '<span class="mb-1 badge text-bg-info">EN PROCESO</span>';
                } elseif ($evaluacion->estado == 3) {
                    return '<span class="mb-1 badge text-bg-danger">RECHAZADO</span>';
                } else {
                    return '<span class="mb-1 badge text-bg-warning">EN ESPERA</span>';
                }
            })
            ->editColumn('aprobacion.estado', function (evaluacion $evaluacion) {
                if ($evaluacion->aprobacion && $evaluacion->teorica) {
                    if ($evaluacion->aprobacion->estado == 1) {
                        return '<span class="mb-1 badge text-bg-success text-dark">ACREDITADO</span>';
                    } else {
                        return '<span class="mb-1 badge text-bg-danger">NO ACREDITADO</span>';
                    }
                }
                return '<span class="mb-1 badge text-bg-info">EN ESPERA</span>';
            })
            ->rawColumns(['acciones', 'estado', 'aprobacion.estado'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Evaluacion $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Evaluacion $model): QueryBuilder
    {
        return $model->newQuery()->with(['candidato', 'empresa', 'faena', 'area', 'perfilEvaluacion', 'creador', 'aprobacion'])->select('evaluaciones.*')->when(!Auth::user()->hasRole(['administrador', 'evaluador']), function ($query) {
            return $query->whereRelation('empresa', 'id', Auth::user()->perfil->empresa->id);
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
            ->setTableId('evaluacion-table')
            ->parameters([
                'lengthMenu' => [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'Todo']
                ]
            ])
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->dom(" <'row'<'col-sm-12 p-0 'B><'col-sm-6' l><'col-sm-6 p-0'>>
                    <'row'<'col-sm-12'tr>>
                    <'row mt-3 '<'col-sm-5'i><'col-sm-7'p>>")
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([])
            ->language([
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
            Column::make('id'),
            Column::make('candidato.rut')->title('RUT'),
            Column::make('empresa.nombre')->title('Empresa'),
            Column::make('faena.nombre')->title('Faena'),
            Column::make('aprobacion.estado')->title('Aprobacion'),
            Column::make('estado')->title('Estado'),
            Column::computed('acciones')->addClass('text-center')->exportable(false)->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Evaluacion_' . date('YmdHis');
    }
}
