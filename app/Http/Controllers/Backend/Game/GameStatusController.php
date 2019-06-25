<?php

namespace App\Http\Controllers\Backend\Game;

use App\Models\Game\Game;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Game\ManageGameRequest;
use App\Repositories\Backend\Game\GameRepository;

class GameStatusController extends Controller
{
    protected $games;

    /**
     * @param GameRepository $games
     */
    public function __construct(GameRepository $games)
    {
        $this->games = $games;
    }

    /**
     * @param ManageGameRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDeleted(ManageGameRequest $request)
    {
        return view('backend.games.deleted');
    }

    /**
     * @param Game $deletedGame
     * @param ManageGameRequest $request
     * @return mixed
     */
    public function delete(Game $deletedGame, ManageGameRequest $request)
    {
        $this->games->forceDelete($deletedGame);

        return redirect()
                ->route('admin.game.index')
                ->withFlashSuccess(trans('alerts.backend.games.deleted_permanently'));
    }


    /**
     * Need to bind the 'deletedGame' inside the routeServiceProvider to grab the model with trashedData
     *
     * @param Game $deletedGame
     * @param ManageGameRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function restore(Game $deletedGame, ManageGameRequest $request)
    {
        $this->games->restore($deletedGame);

        return redirect()
            ->route('admin.game.index')
            ->withFlashSuccess(trans('alerts.backend.games.restored'));
    }

}
