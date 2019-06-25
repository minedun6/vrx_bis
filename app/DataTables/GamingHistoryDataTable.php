<?php

namespace App\DataTables;

use Carbon\Carbon;
use DB;
use Yajra\Datatables\Services\DataTable;
use Cache;

class GamingHistoryDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $request = $this->request();
        return $this->datatables
            ->queryBuilder($this->query())
            ->editColumn('is_payed', function ($gamingHistory) {
                return $gamingHistory->is_payed ? '<small class="label bg-green">Payant</small>' : '<small class="label bg-red">Non Payant</small>';
            })
            ->editColumn('game_name', function ($gamingHistory) {
                return link_to_route('admin.game.edit', $gamingHistory->game_name, $gamingHistory->historics_game_id);
            })
            ->editColumn('box_code', function ($gamingHistory) {
                return link_to_route('admin.box.show', $gamingHistory->box_code, $gamingHistory->historics_box_id);
            })
            ->editColumn('worker_name', function ($gamingHistory) {
                return $gamingHistory->worker_name;
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('filter_game') && $request->has('filter_game') != '') {
                    $query->where('game_id', $request->get('filter_game'));
                }
                if ($request->has('filter_box') && $request->has('filter_box') != '') {
                    $query->where('box_id', $request->get('filter_box'));
                }
                if ($request->has('filter_worker') && $request->has('filter_worker') != '') {
                    $query->where('worker_id', $request->get('filter_worker'));
                }
                if ($request->has('filter_played_at') && $request->has('filter_played_at') != '') {
                    $dates = explode(' - ', $request->get('filter_played_at'));
                    $start = Carbon::parse($dates[0]);
                    $end = Carbon::parse($dates[1]);
                    $query->whereBetween('played_at', [$start, $end]);
                }
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
        $query = DB::table('historics')
            ->leftJoin('games', 'games.id', '=', 'historics.game_id')
            ->leftJoin('boxes', 'boxes.id', '=', 'historics.box_id')
            ->leftJoin('workers', 'workers.id', '=', 'historics.worker_id')
            ->leftJoin('users', 'users.id', '=', 'workers.user_id')
            ->select(
                DB::raw('games.name as game_name'),
                DB::raw('boxes.code as box_code'),
                DB::raw('users.name as worker_name'),
                DB::raw('historics.played_at as game_played_at'),
                DB::raw('historics.is_payed as is_payed'),
                DB::raw('historics.players_number as players_number'),
                DB::raw('worker_id as historics_worker_id'),
                DB::raw('game_id as historics_game_id'),
                DB::raw('box_id as historics_box_id'),
                'price'
            );

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
            'game_name' => ['title' => 'Jeu Lancé'],
            'box_code' => ['title' => 'Box'],
            'worker_name' => ['title' => 'Supérviseur'],
            'game_played_at' => ['title' => 'Lancé à'],
            'is_payed' => ['title' => 'Payant ou Non'],
            'players_number' => ['title' => 'Nombre de Joueurs'],
            'price' => ['title' => 'Montant Payé']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'history_' . time();
    }
}
