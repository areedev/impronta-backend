<?php

namespace App\DataTables;

use App\Models\Candidato;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class CandidatoDataTable extends DataTable
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
            ->addColumn('acciones', function (Candidato $candidato) {
                return view('candidato.acciones', compact('candidato'));
            })
            ->editColumn('nombre', function (Candidato $candidato) {
                $logo = !is_null($candidato->foto) ? '../uploads/candidatos/'.$candidato->id.'/foto/'.$candidato->foto.'' : '../assets/images/profile/user.png';
                return '<div class="d-flex align-items-center">
                <img src="'.$logo.'" alt="avatar" class="rounded-circle" width="50">
                <div class="ms-3">
                  <div class="user-meta-info">
                    <h5 class="user-name mb-0">'.$candidato->nombre.'</h5>
                  </div>
                </div>
              </div>';
            })
            ->editColumn('estado', function (Candidato $candidato) {
                if ($candidato->estado == 1) {
                    return '<span class="mb-1 badge text-bg-success">Activo</span>';
                } else {
                    return '<span class="mb-1 badge text-bg-danger">Inactivo</span>';
                }
            })
            ->rawColumns(['acciones','nombre', 'estado'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Candidato $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Candidato $model): QueryBuilder
    {
        return $model->newQuery()->with(['empresa'])->when(!Auth::user()->hasRole(['administrador', 'evaluador']), function ($query) {
            return $query->whereRelation('empresa','id', Auth::user()->perfil->empresa->id);
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
            ->setTableId('candidato-table')
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
            Column::make('id')->title('Nº Candidato'),
            Column::make('nombre')->title('Nombre Candidato'),
            Column::make('empresa.nombre')->title('Empresa'),
            Column::make('telefono')->title('Número'),
            Column::make('estado')->title('Estado'),
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
        return 'Candidato_' . date('YmdHis');
    }
}
