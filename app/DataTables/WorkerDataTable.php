<?php

namespace App\DataTables;

use App\Models\Worker\Worker;
use App\Repositories\Backend\Access\User\UserRepository;
use App\Repositories\Backend\Location\LocationRepository;
use App\Repositories\Backend\Worker\WorkerRepository;
use Yajra\Datatables\Services\DataTable;
use App\Models\Location\Location;

class WorkerDataTable extends DataTable
{

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('actions', function ($worker) {
                return $worker->action_buttons;
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Worker::with(['user', 'box']);
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return
            $this->builder()
                ->columns($this->getColumns())
                ->parameters([
                    'dom' => "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><''t><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                    'buttons' => [
                        ['extend' => 'print', 'className' => 'btn xs default'],
                        ['extend' => 'excel', 'className' => 'btn xs default'],
                        ['extend' => 'pdf', 'className' => 'btn xs default'],
                    ],
                    'language' => config('datatables.language_trans')
                ])->setTableAttribute(['class' => 'table dataTable no-footer table-bordered table-condensed']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'code' => ['name' => 'code', 'data' => 'code', 'title' => 'Code Supérviseur'],
            'name' => ['name' => 'user.name', 'data' => 'user.name', 'title' => 'Nom du Supérviseur'],
            'email' => ['name' => 'user.email', 'data' => 'user.email', 'title' => 'Adresse Email'],
            'phone1' => ['name' => 'phone1', 'data' => 'phone1', 'title' => 'Num Téléphone #1'],
            'default_box' => ['name' => 'box.code', 'data' => 'box.code', 'title' => 'Box par défault'],
            'started_at' => ['name' => 'started_at', 'data' => 'started_at', 'title' => 'Supérviseur depuis'],
            'actions' => ['searchable' => false, 'exportable' => 'false', 'printable' => false, 'orderable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'workers_' . time();
    }
}
