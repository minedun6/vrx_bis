<?php

namespace App\DataTables;

use App\Models\Affectation\Affectation;
use App\Repositories\Backend\Affectation\AffectationRepository;
use App\User;
use Yajra\Datatables\Services\DataTable;

class AffectationDataTable extends DataTable
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
            ->addColumn('actions', function ($affectation) {
                return $affectation->action_buttons;
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
        $repo = new AffectationRepository;
        $query = $repo->getForDataTable();
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf', 'print', 'reset', 'reload'],
            ])
            ->setTableAttribute(['class' => 'table dataTable no-footer table-bordered table-condensed']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'created_at' => ['title' => 'Date of Assignement', 'created_at'],
            'worker_id' => ['title' => 'Affected Worker', 'data' => 'worker.user.name'],//Todo Make a custom Global filter
            'box_id' => ['title' => 'Box to be Assigned To', 'name' => 'box.code', 'data' => 'box.code'],
            'updated_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'affectations_' . time();
    }
}
