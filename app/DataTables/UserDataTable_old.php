<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Location;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    
    //  protected $searchColumns = [
    //     'name',
    //     'email',
    //     'location', // Add 'location' as a searchable column
    //     'regiment', // Add 'regiment' as a searchable column
    //     'last_login_ip',
    //     'last_login_date',
    // ];

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $locations = Location::getLocationsFromAPI();

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('last_login_date', function ($user) {
                if($user->last_login_date)
                {
                    return Carbon::parse($user->last_login_date)->format('Y-m-d');
                }else{
                    return 'N/A';
                }
                
            })
            ->addColumn('status', function($status){
                return ($status->status==1)?'<h5><span class="badge badge-primary">Active</span></h5>':
                '<h5><span class="badge badge-warning">Inactive</span></h5>';
            })            
            ->addColumn('location', function ($user) use ($locations) {
                //$locations = Location::getLocationsFromAPI();
                $location_id = $user->location_id;
            
                if ($location_id) {
                    $key = array_search($location_id, array_column($locations, 'id'));
                    
                    if ($key !== false) {
                        return $locations[$key]['name'];
                    } else {
                        return 'Location not found';
                    }
                } else {
                    return 'N/A';
                }
            })
            ->addColumn('regiment', function ($user) use ($locations) {
                //$locations = Location::getLocationsFromAPI();
                $location_id = $user->regiment_id;
            
                if ($location_id) {
                    $key = array_search($location_id, array_column($locations, 'id'));
                    
                    if ($key !== false) {
                        return $locations[$key]['name'];
                    } else {
                        return 'Location not found';
                    }
                } else {
                    return 'N/A';
                }
            })
            ->addColumn('action', function ($user) {
                $btn = '';
                    $btn .= '<a href="'.route('users.edit',$user->id).'"
                    class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-pen-alt"></i> </a> ';

                    $btn .= '<a href="'.route('users.show',$user->id).'"
                    class="btn btn-xs btn-secondary" data-toggle="tooltip" title="View">
                    <i class="fa fa-eye"></i> </a> ';

                    $btn .= '<a href="'.route('users.resetpass',$user->id).'"
                    class="btn btn-xs btn-warning" data-toggle="tooltip" title="reset Password">
                    <i class="fa fa-redo"></i> </a> ';

                    if($user->status==1)
                    {
                        $btn .='<a href="'.route('users.suspend',$user->id).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Suspend"><i class="fa fa-trash"></i> </a> ';

                    }elseif($user->status==0)
                    {
                        $btn .='<a href="'.route('users.activate',$user->id).'"
                        class="btn btn-xs btn-danger" data-toggle="tooltip"
                        title="Activate"><i class="fa fa-unlock"></i> </a> ';
                    }


           return $btn;
            })

            ->addColumn('roles', function ($user) {
                $roles = $user->getRoleNames();
                $badges = '';

                if (!empty($roles)) {
                    foreach ($roles as $role) {
                        $badges .= '<label class="badge badge-success">' . $role . '</label>';
                    }
                }

                return $badges;
            })
            ->rawColumns(['action','roles','status','location','regiment']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
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
                    // ->searchBuilder();
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
                  ->width(90)
                  ->addClass('text-center'),
            Column::make('name')->data('name')->title('Name'),
            Column::make('email')->data('email')->title('Email'),            
            Column::computed('roles'),
            Column::computed('location')->title('Location'),
            Column::computed('regiment')->title('Regiment'),                
            Column::computed('status'),
            Column::make('last_login_ip')->data('last_login_ip')->title('Last Login IP'),
            Column::make('last_login_date')->data('last_login_date')->title('Last Login Date'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
