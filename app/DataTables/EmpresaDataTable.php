<?php

namespace App\DataTables;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmpresaDataTable extends DataTable
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
            ->addColumn('acciones', function (Empresa $empresa) {
                return view('empresa.acciones', compact('empresa'));
            })
            ->editColumn('nombre', function (Empresa $empresa) {
                $logo = !is_null($empresa->logo) ? '../uploads/empresa/'.$empresa->id.'/logo/'.$empresa->logo.'' : '../assets/images/profile/user.png';
                return '<div class="d-flex align-items-center">
                <img src="'.$logo.'" alt="avatar" class="rounded-circle" width="50">
                <div class="ms-3">
                  <div class="user-meta-info">
                    <h5 class="user-name mb-0" data-name="Emma Adams">'.$empresa->nombre.'</h5>
                  </div>
                </div>
              </div>';
            })
            /*->addColumn('created_at', function (Empresa $empresa) {
                return $empresa->created_at->format('d-m-Y h:i');
            })*/
            ->addColumn('cantidad_candidatos', function (Empresa $empresa) {
                return '<a class="text-info" href="#">0</a>';
            })
            ->addColumn('cantidad_evaluaciones', function (Empresa $empresa) {
                return '<a class="text-info" href="#">0</a>';
            })
            ->addColumn('cantidad_evaluaciones_aprobadas', function (Empresa $empresa) {
                return '<a class="text-info" href="#">0</a>';
            })
            ->rawColumns(['acciones','nombre', 'cantidad_candidatos', 'cantidad_evaluaciones', 'cantidad_evaluaciones_aprobadas'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Empresa $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Empresa $model): QueryBuilder
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
            ->setTableId('empresa-table')
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
            Column::make('nombre')->width('250px'),
            Column::make('cantidad_candidatos')->title('Cantidad de Colaboradores')->searchable(false)->orderable(false),
            Column::make('cantidad_evaluaciones')->title('Evaluaciones Realizadas')->searchable(false)->orderable(false),
            Column::make('cantidad_evaluaciones_aprobadas')->title('Evaluaciones Aprobadas')->searchable(false)->orderable(false),
            //Column::make('created_at')->title('Fecha de Creación'),
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
        return 'Empresa_' . date('YmdHis');
    }
}
