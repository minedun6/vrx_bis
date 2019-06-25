<?php
/**
 * Created by PhpStorm.
 * User: AIO2
 * Date: 21/12/2016
 * Time: 16:39
 */

namespace App\Models\Game\Traits\Relationship;


use App\Models\Box\Box;
use App\Models\Game\Game;
use App\Models\Worker\Worker;

trait GameHistoryRelationship
{

    /**
     * @return mixed
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @return mixed
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * @return mixed
     */
    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}