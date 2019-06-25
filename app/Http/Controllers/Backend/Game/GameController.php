<?php

namespace App\Http\Controllers\Backend\Game;

use App\DataTables\GameDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Game\ManageGameRequest;
use App\Http\Requests\Backend\Game\StoreGameRequest;
use App\Http\Requests\Backend\Game\UpdateGameRequest;
use App\Models\Game\Game;
use App\Repositories\Backend\Game\GameRepository;

class GameController extends Controller
{
    /**
     * @var
     */
    protected $games;

    /**
     * @param GameRepository $games
     */
    function __construct(GameRepository $games)
    {
        $this->games = $games;
    }


    /**
     * Display a listing of the resource.
     *
     * @param ManageGameRequest $request
     * @param GameDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ManageGameRequest $request, GameDataTable $dataTable)
    {
        return $dataTable->render('backend.games.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ManageGameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(ManageGameRequest $request)
    {
        return view('backend.games.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreGameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $this->games->create(['data' => $request->all()]);
        return redirect()
            ->route('admin.game.index')
            ->withFlashSuccess(trans('alerts.backend.games.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param Game $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {

        return view('backend.games.show')->with('game', $game);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Game $game
     * @param ManageGameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game, ManageGameRequest $request)
    {
        return view('backend.games.edit')
            ->withGame($game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Game $game
     * @param UpdateGameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Game $game, UpdateGameRequest $request)
    {
        $this->games->update($game, ['data' => $request->all()]);

        return redirect()
            ->route('admin.game.index')
            ->withFlashSuccess(trans('alerts.backend.games.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @param ManageGameRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game, ManageGameRequest $request)
    {
        $this->games->delete($game);

        return redirect()
            ->route('admin.game.index')
            ->withFlashSuccess(trans('alerts.backend.games.deleted'));
    }
}
