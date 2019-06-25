<?php

namespace App\Http\Controllers\Backend\GameHistory;

use App\DataTables\GamingHistoryDataTable;
use App\Models\Box\Status;
use App\Repositories\Backend\Box\BoxRepository;
use App\Repositories\Backend\Game\GameRepository;
use App\Repositories\Backend\Worker\WorkerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameHistoryController extends Controller
{

    protected $workers;

    protected $games;

    protected $boxes;

    /**
     * GameHistoryController constructor.
     * @param WorkerRepository $workers
     * @param BoxRepository $boxes
     * @param GameRepository $games
     * @internal param $statuses
     */
    public function __construct(WorkerRepository $workers, BoxRepository $boxes, GameRepository $games)
    {
        $this->workers = $workers;
        $this->boxes = $boxes;
        $this->games = $games;
    }


    /**
     * Display a listing of the resource.
     *
     * @param GamingHistoryDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(GamingHistoryDataTable $dataTable)
    {
        return $dataTable->render('backend.games.history.index', [
            'boxes' => $this->boxes->getAll(),
            'workers' => $this->workers->getAll(),
            'games' => $this->games->getAll()
        ]);
    }
}
