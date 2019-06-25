<?php

namespace App\DataTables;

use App\Repositories\Backend\Game\GameRepository;
use Yajra\Datatables\Services\DataTable;

class GameDataTable extends DataTable
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
            ->editColumn('actions', function ($game) {
                return $game->action_buttons;
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
        $repo = new GameRepository();
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
        return
            $this->builder()
                ->columns($this->getColumns())
                ->parameters([
                    'dom' => "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
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
            'code' => ['name' => 'code', 'data' => 'code', 'title' => 'Code du Jeu'],
            'name' => ['name' => 'name', 'data' => 'name', 'title' => 'Nom du Jeu'],
            'bought_at' => ['name' => 'bought_at', 'data' => 'bought_at', 'title' => 'Acheté le'],
            'duration' => ['name' => 'duration', 'data' => 'duration', 'title' => 'Durée'],
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
        return 'games_' . time();
    }
}
