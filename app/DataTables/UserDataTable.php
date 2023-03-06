<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
                return '<div class="dropdown"><a id="actionBtt" data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-ellipsis-h"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="/user/givepermission/'.$row->id.'" class="dropdown-item"><i class="la la-caret-up"></i> Give Permission</a><a href="/user/removepermission/'.$row->id.'" class="dropdown-item"><i class="la la-caret-down"></i> Remove Permission</a></div></div>';
           })
           ->editcolumn('permission', function($row) {
            if($row->permission!=3)
                return 'N/A';
            else
            return '<span><i class="la la-check-circle-o"></i></span>';
       })
           ->rawColumns(['actions' => 'actions','permission']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('user-table')
                    ->serverSide(true)
                    ->ajax(['type' => 'POST', 'data' => '{"_method":"GET"}'])
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
                    }",])
                    ->orderBy(3)
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lfrtip');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('actions')->title(''),
            Column::make('name')->title('Name'),
            Column::make('zf_number')->title('ZF Number'),
            Column::make('permission')->title('Permission'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
