<?php

namespace App\DataTables;

use App\Models\Booking;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class PendingBookingApproveDataTable extends DataTable
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
            ->addColumn('status', function($booking){

                if($booking->filpath || $booking->level == 3)
                {
                    return '<h5><span class="badge badge-pill badge-info">Paid</span></h5>';
                }else{
                    return '<h5><span class="badge badge-pill badge-warning">Not-Paid</span></h5>';
                }

            })
            ->addColumn('action', function ($booking) {
                $id = $booking->id;
                $btn = ' ';

                if($booking->cancel == 0)
                {
                    $btn .='<a href="'.route('bookings.cancel_booking_view',$id).'"
                            class="btn btn-xs btn-danger" data-toggle="tooltip"
                            title="Cancel booking"><i class="fa fa-times"></i> </a> ';
                }

                if($booking->filpath)
                {
                    $btn .='<a href="'.route('bookings.booking_approve',$id).'"
                            class="btn btn-xs btn-success" data-toggle="tooltip"
                            title="Approve booking"><i class="fa fa-check"></i> </a> ';
                }

                return $btn;
            })
            ->rawColumns(['action','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Booking $model): QueryBuilder
    {
        return $model->newQuery()
        ->where('type', 1)
        //->whereNotNull('filpath')
        ->where('approve',0)
        ->where('cancel',0)
        ->whereDoesntHave('approve')
        ->with('bungalow');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pendingbookingapprove-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('svc_no')->data('svc_no')->title('Svc No.'),
            Column::make('rank')->data('rank')->title('Rank'),
            Column::make('name')->data('name')->title('Name'),
            Column::make('check_in')->data('check_in')->title('check in'),
            Column::make('check_out')->data('check_out')->title('check out'),
            Column::make('bungalow.name')->data('bungalow.name')->title('Bungalow'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(110)
                  ->addClass('text-center'),
            Column::computed('status')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PendingBookingApprove_' . date('YmdHis');
    }
}
