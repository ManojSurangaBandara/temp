<?php

namespace App\DataTables;

use App\Models\Directorate;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DirectorateDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('status', function($directorate){
                return ($directorate->status==1)?'<h5><span class="badge badge-primary">Active</span></h5>':
                '<h5><span class="badge badge-warning">Inactive</span></h5>';
            })
            ->addColumn('action', function ($directorate) {
                $id = $directorate->id;
                $btn = '';
                    $btn .= '<a href="'.route('directorates.edit',$id).'"
                    class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-pen-alt"></i> </a> ';

                    if($directorate->status==1)
                    {
                        $btn .='<a href="'.route('directorates.inactive',$id).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Suspend"><i class="fa fa-trash"></i> </a> ';

                    }elseif($directorate->status==0)
                    {
                        $btn .='<a href="'.route('directorates.activate',$id).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Activate"><i class="fa fa-unlock"></i> </a> ';
                    }

                return $btn;
            })
            ->rawColumns(['action','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Directorate $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('directorate-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('add'),
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderColumn(false)->width(40),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
            Column::make('name')->data('name')->title('Name'),
            Column::computed('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Directorate_' . date('YmdHis');
    }
}
