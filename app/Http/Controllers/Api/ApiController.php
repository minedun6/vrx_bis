<?php

namespace App\Http\Controllers\Api;

use App\Models\Access\Role\Role;
use App\Models\Box\Box;
use App\Models\Box\Status;
use App\Models\Game\Game;
use App\Notifications\BoxCreatedNotification;
use App\Notifications\GameCreatedNotification;
use App\Repositories\Backend\Box\BoxRepository;
use App\Repositories\Backend\Game\GameRepository;
use App\Repositories\Backend\Worker\WorkerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Notification;
use JWTAuth;
use Validator;
use DB;

class ApiController extends Controller
{
    protected $games;

    protected $workers;

    protected $boxes;

    protected $gameHistorics;

    protected $boxPrice1 = 10;
    protected $boxPrice2 = 15;
    protected $boxPrice3 = 20;

    public function __construct(GameRepository $games, WorkerRepository $workers, BoxRepository $boxes)
    {
        $this->games = $games;
        $this->workers = $workers;
        $this->boxes = $boxes;

        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
        $this->gameHistorics = $this->games->gameHistoryQuery()->get();
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return $token;
    }

    protected function rules()
    {
        return [
            'game' => 'required',
            'box' => 'required',
            'worker' => 'required',
            'is_payed' => 'required|in:0,1',
            'player_numbers' => 'required|in:1,2,3'
        ];
    }

    public function saveGameHistory(Request $request)
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $validator = Validator::make($request->only([
            'game', 'box', 'worker', 'is_payed', 'player_numbers'
        ]), $this->rules());

        DB::transaction(function () use ($request) {
            $this->processRequest($request);
        });

    }

    protected function processRequest(Request $request)
    {
        $adminUsers = Role::find(1)->users;
        foreach ($request->json()->all() as $req) {
            $game = $this->games->query()->where('code', '=', $req['game'])->first();
            $box = $this->boxes->query()->where('code', '=', $req['box'])->first();
            $worker = $this->workers->query()->where('code', '=', $req['worker'])->first();
            $isPayed = $req['is_payed'];
            $playerNumbers = $req['player_numbers'];
            $playedAt = Carbon::createFromTimestamp($req['played_at']);

            if (is_null($game)) {
                $game = new Game;
                $game->code = $req['game'];
                $game->save();

                // Notification Game created from the Api
                Notification::send($adminUsers, new GameCreatedNotification($game));
            }

            if (is_null($box)) {
                $box = new Box;
                $box->code = $req['box'];
                $box->price1 = $this->boxPrice1;
                $box->price2 = $this->boxPrice2;
                $box->price3 = $this->boxPrice3;
                // get the status "En Activité"

                $activeStatus = Status::find(1)->first();
                $box->box_status = $activeStatus->id;
                $box->save();

                $box->statuses()->save($activeStatus);

                // Notification Box created from the Api
                Notification::send($adminUsers, new BoxCreatedNotification($box));
            }
            if ($box) {
                $unwanted = Status::where('id', 2)->orWhere('id', 3)->get();
                if ($unwanted->contains($box->box_status)) {

                    $activeStatus = Status::find(1)->first();
                    $box->box_status = $activeStatus->id;
                    $box->save();

                    $box->statuses()->save($activeStatus);
                }
            }
            if (!$this->exists($box, $playedAt)) {
                $history = $box->games()
                    ->save($game, [
                        'worker_id' => $worker->id,
                        'played_at' => $playedAt,
                        'is_payed' => $isPayed,
                        'price' => $this->getBoxPrice($box, $isPayed, $playerNumbers),
                        'players_number' => $playerNumbers
                    ]);
                return "OK";
            } else {
                // Box with existing played_at timestamp exists
            }
        }
        return "OK";
    }

    protected function exists($box, $timestamp)
    {
        foreach ($this->gameHistorics as $gameHistoric) {
            if ($gameHistoric->box_id == $box->id && $gameHistoric->played_at == $timestamp) {
                return true;
            }
        }
        return false;
    }

    protected function getBoxPrice($box, $is_paid, $players_number)
    {
        if ($is_paid == 1) {
            switch ($players_number) {
                case '1':
                    // add default price
                    $price = $box->price1 ?? $this->boxPrice1;
                    break;
                case '2':
                    $price = $box->price2 ?? $this->boxPrice2;
                    break;
                case '3':
                    $price = $box->price3 ?? $this->boxPrice3;
                    break;
                default:
                    $price = 0;
                    break;
            };
        } else if ($is_paid == 0) {
            $price = 0;
        }
        return $price;
    }
}
