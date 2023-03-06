<?php

namespace App\DataTables;

//import m,odels
use App\Models\Acoes;
//import controllers
use App\Http\Controllers\AcoesController;
//import outeros
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Carbon;

use Auth;

class AcoesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        setlocale(LC_TIME, 'PT_pt');
        //objeto expedicoes
        $aux = new Acoes();
        //obter selecionado no dropdown
        $dpto = $this->request()->get('name_department');

        //obter selecionado dorpdown input
        $input = $this->request()->get('name_input');

        //obter selecionado dorpdown location
        $location = $this->request()->get('location');

        //detecta nulos
        $aux = AcoesController::detectNull($this->estado, $dpto, $input, $location);


        return datatables()
            ->of($aux)
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown teste">
                            <a id="actionBtt" data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                <i class="fas fa-cogs pr-2"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="/acoes/details/' . $row->idissue . '" class="dropdown-item">
                                    <i class="la la-eye"></i> Details
                                </a>
                                <a onclick="on();" class="dropdown-item">
                                    <i class="la la-leaf"></i> Add Remark
                                </a>
                                <a onclick="onConc();" class="dropdown-item">
                                    <i class="la la-hand-peace-o"></i> Conclude Issue
                                </a>
                                <a onclick="onCanc();" class="dropdown-item">
                                    <i class="la la-calendar-times-o"></i> Cancel Issue
                                </a>
                                <a href="/acoes/edit/' . $row->idissue . '" class="dropdown-item">
                                    <i class="la la-edit"></i> Edit Issue
                                </a>
                            </div>
                        </div>';
            })

            ->editColumn('number_priority', function ($row) {
                if ($row->number_priority === 'High') {
                    return '<span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">' . $row->number_priority . '</span>';
                }
                if ($row->number_priority === 'Medium') {
                    return '<span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">' . $row->number_priority . '</span>';
                }
                if ($row->number_priority === 'Low') {
                    return '<span class="kt-badge  kt-badge--brand kt-badge--inline kt-badge--pill">' . $row->number_priority . '</span>';
                }
                if ($row->number_priority === 'TBD') {
                    return '<span class="kt-badge  kt-badge--dark kt-badge--inline kt-badge--pill">' . $row->number_priority . '</span>';
                }
            })
            ->editColumn('startDate', function ($acao) {
                return Carbon::parse($acao->startDate)->format('Y-m-d');
            })
            ->editColumn('condition', function ($acao) {

                if ($acao->endDate < Carbon::now() && ($acao->condition === 'Processing' || $acao->condition === '')) {
                    return '<span class="kt-font-danger"><strong>Delay</strong></span>';
                } else if (($acao->endDate > Carbon::now()) &&  $acao->condition === '') {
                    return 'Processing';
                } else if ($acao->condition === 'Concluded') {
                    return '<span class="kt-font-success"><strong>Concluded</strong></span>';
                } else {
                    return $acao->condition;
                }
            })

            ->editColumn('name_responsible', function ($acao) {

                $firstCharacter = substr($acao->name_responsible, 0, 1);
                if ($firstCharacter == '4' || $firstCharacter == '6') {
                    return AcoesController::getName($acao->name_responsible);
                } else {
                    return $acao->name_responsible;
                }
            })
            ->rawColumns(['actions', 'number_priority', 'condition']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MinhasAco $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Acoes $model)
    {


        $query = $model->newQuery();
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
            ->serverSide(true)
            ->pageLength(25)
            ->lengthChange(true)
            ->lengthMenu([[10, 25, 50, -1], [10, 25, 50, "All"]])
            ->select(true)
           /* ->parameters(['initComplete' => "function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement(\"input\");
                    $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                });
            }"])*/
            ->columns($this->getColumns())
            ->responsive(true)
            ->orderBy(11, 'desc')
            ->dom( "<'row'<'col-4 text-left'B>><'row'<'col-6 text-left'l><'col-6 text-right'f>><'row'<'col-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>")
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
            Column::make('actions')->exportable(false)->title('Actions')->printable(false),
            Column::make('idissue')->title('ID.')->visible(false),
            Column::make('startDate')->title('Start. Dt.'),
            Column::make('issueDescription')->title('Issue'),
            Column::make('correctiveMeasure')->title('Action'),
            Column::make('name_responsible')->title('Respon.'),
            Column::make('name_localization')->title('Proj.'),
            Column::make('number_priority')->title('Priority')->exportable(false),
            Column::make('condition')->title('State')->exportable(false),
            Column::make('name_department')->title('Dept.'),
            Column::make('name_input')->title('Input'),
            Column::make('priorityissue')->title('Priority Number')->visible(false)->exportable(false),
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
        return 'TodasAcoes_' . date('YmdHis');
    }
}
