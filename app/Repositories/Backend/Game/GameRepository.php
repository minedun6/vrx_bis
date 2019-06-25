<?php

namespace App\Repositories\Backend\Game;

use App\Exceptions\GeneralException;
use App\Models\Game\Game;
use App\Models\Game\GameHistoric;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GameRepository extends Repository
{

    /**
     * Associated Repository Model
     */
    const MODEL = Game::class;

    public function getForDataTable($trashed = false)
    {
        return $this->query();
    }

    public function create($input)
    {
        $data = $input['data'];

        $game = $this->createGameStub($data);

        DB::transaction(function () use ($game, $data) {
            if (parent::save($game)) {

                //Todo event(new GameCreated($game));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function update(Model $game, array $input)
    {
        $data = $input['data'];

        $this->checkGameByCode($data, $game);

        DB::transaction(function () use ($game, $data) {
            if (parent::update($game, $data)) {
                parent::save($game);
                //Todo event(new GameUpdated($game));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     * @param Model $game
     * @return bool
     * @throws GeneralException
     */
    public function delete(Model $game)
    {
        if (parent::delete($game)) {
            //Todo event(new GameDeleted($game));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
    }

    protected function checkGameByCode($input, $game)
    {
        //Figure out if email is not the same
        if ($game->code != $input['code']) {
            //Check to see if email exists
            if ($this->query()->where('code', '=', $input['code'])->first()) {
                throw new GeneralException(trans('exceptions.backend.access.users.email_error'));
            }
        }
    }

    /**
     * @param Model $game
     * @return bool|null|void
     * @throws GeneralException
     */
    public function forceDelete(Model $game)
    {
        if (is_null($game->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.delete_first'));
        }

        DB::transaction(function () use ($game) {
            if (parent::forceDelete($game)) {
                //Todo event(new UserPermanentlyDeleted($game));
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @param Model $game
     * @return bool
     * @throws GeneralException
     */
    public function restore(Model $game)
    {
        if (is_null($game->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_restore'));
        }

        if (parent::restore(($game))) {
            //Todo event(new UserRestored($game));
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.restore_error'));
    }

    /**
     * @param  $input
     * @return mixed
     */
    protected function createGameStub($input)
    {
        $game = self::MODEL;
        $game = new $game;
        $game->code = $input['code'];
        $game->name = $input['name'] ?? null;
        $game->bought_at = $input['bought_at'] ?? null;
        $game->duration = $input['duration'] ?? null;
        return $game;
    }

    public function topPlayedGames($box = null, $number = 10)
    {
        if (is_null($box)) {
            return parent::query()
                ->withCount('boxes')
                ->orderBy('boxes_count', 'desc')
                ->take($number)
                ->get();
        } else {
            return parent::query()
                ->withCount(['boxes' => function ($q) use ($box) {
                    $q->where('box_id', $box->id);
                }])
                ->orderBy('boxes_count', 'desc')
                ->take($number)
                ->get();


        }
    }

    public function gameHistoryQuery()
    {
        return GameHistoric::query();
    }

    public function query()
    {
        return parent::query();
    }


}