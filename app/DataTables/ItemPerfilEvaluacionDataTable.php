<?php

namespace App\DataTables;

use App\Models\ItemPerfilEvaluacion;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ItemPerfilEvaluacionDataTable extends DataTable
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
            ->addColumn('acciones', function (ItemPerfilEvaluacion $item) {
                return view('itemperfilevaluacion.acciones', compact('item'));
            })
            ->addColumn('created_at', function (ItemPerfilEvaluacion $item) {
                return $item->created_at->format('d-m-Y h:i');
            })
            ->addColumn('usuario_creador', function (ItemPerfilEvaluacion $item) {
                return ($item->creador) ? $item->creador->nombre . ' ' . $item->creador->apellido : 'No Encotrado';
            })
            ->rawColumns(['acciones'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ItemPerfilEvaluacion $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ItemPerfilEvaluacion $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('itemperfilevaluacion-table')
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
            ->orderBy(1)
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
            Column::make('nombre'),
            Column::make('usuario_creador')->title('Creado por'),
            Column::make('created_at')->title('Fecha Creación'),
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
        return 'ItemPerfilEvaluacion_' . date('YmdHis');
    }
}
