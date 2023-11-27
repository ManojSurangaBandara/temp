<?php

namespace App\DataTables;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BookingDataTable extends DataTable
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
            // ->addColumn('status', function($booking){
            //     $label = '';
            //     else{
            //         $btn .= '<h5><span class="badge badge-warning">paid</span></h5>';
            //     }

            // })
            ->addColumn('action', function ($booking) {
                $id = $booking->id;
                $btn = '';

                if(!$booking->filpath)
                {
                    $btn .= '<a href="'.route('bookings.upload_payment_view',$id).'"
                    class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-upload"></i> </a> '; 
                }
                
                if($booking->cancel == 0)
                {
                    $btn .='<a href="'.route('bookings.cancel_booking_view',$id).'"
                            class="btn btn-xs btn-danger" data-toggle="tooltip"
                            title="Cancel booking"><i class="fa fa-times"></i> </a> ';
                }
                
                if($booking->filpath && $booking->refund == 0 && ($booking->cancel == 1 || $booking->cancel == 2))
                {
                    $btn .='<a href="'.route('bookings.refund_booking',$id).'"
                            class="btn btn-xs btn-success" data-toggle="tooltip"
                            title="Refund booking"><i class="fa fa-redo"></i> </a> ';
                }

                return $btn;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Booking $model): QueryBuilder
    {
        return $model->newQuery()
        ->where('bungalow_id',$this->bungalow->id)
        ->with('bungalow');
        //dd($this->bungalow->id); 
        //return $this->bungalow->bookings();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('booking-table')
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(110)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Booking_' . date('YmdHis');
    }
}
