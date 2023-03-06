<?php

namespace App\DataTables;

use App\Models\Acoes;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IssuesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('actions', function($row) {
                return '<div class="dropdown"><a id="actionBtt" data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-ellipsis-h"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="/acoes/details/'.$row->idissue.'" class="dropdown-item"><i class="la la-eye"></i> Details</a><a onclick="on();" class="dropdown-item"><i class="la la-leaf"></i> Add Remark </a><a onclick="onConc();"" class="dropdown-item"><i class="la la-hand-peace-o"></i> Conclude Issue</a><a onclick="onCanc();" class="dropdown-item"><i class="la la-calendar-times-o"></i> Cancel Issue</a><a href="/acoes/edit/'.$row->idissue.'" class="dropdown-item"><i class="la la-edit"></i>Edit Issue</a></div></div>';
           })
            ->rawColumns(['actions' => 'actions', 'number_priority', 'condition']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Acoes $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Acoes $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->setTableId('acoes-datatable')
        ->serverSide(false)
        ->pageLength(25)
        ->lengthChange(true)
        ->lengthMenu([[10, 25, 50, -1], [10, 25, 50, "All"]])
        ->select(true)
        ->parameters(['initComplete' => "function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement(\"input\");
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
            });
        }"])
        ->columns($this->getColumns())
        ->responsive('true')
        ->orderBy(11, 'desc')
        ->dom('Blrtip')
        ->buttons(
            Button::make('excel')->className('btn btn-success')->filename('Todas as Ações')->title('ZF | GAM2.0 - Registos de Ações'),
            Button::make('print')->filename('Todas as Ações')->title('ZF | GAM2.0 - Registos de Ações')->text('Imprimir'),
            Button::make('colvis')->className('btn btn-info dropdown-toggle')->text('Mostrar/Ocultar Colunas')
        );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('actions')->title('Actions'),
            Column::make('idissue')->title('ID.')->visible(false),
            Column::make('startDate')->title('Start. Dt.'),
            Column::make('issueDescription')->title('Issue'),
            Column::make('correctiveMeasure')->title('Action'),
            Column::make('name_responsible')->title('Respon.'),
            Column::make('name_localization')->title('Proj.'),
            Column::make('number_priority')->title('Priority'),
            Column::make('condition')->title('State'),
            Column::make('name_department')->title('Dept.')->visible(false),
            Column::make('name_input')->title('Input')->visible(false),
            Column::make('priorityissue')->title('Priority Number')->visible(false),
            Column::make('endDate')->title('Forecast/End')->visible(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Issues_' . date('YmdHis');
    }
}
