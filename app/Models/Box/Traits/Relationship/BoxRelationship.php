<?php

namespace App\Models\Box\Traits\Relationship;

use App\Models\Box\Box;
use App\Models\Box\BoxStatus;
use App\Models\Box\Status;
use App\Models\Game\Game;
use App\Models\Location\Location;
use App\Models\Worker\Worker;

trait BoxRelationship
{

    /**
     * @return mixed
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * @return mixed
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'box_status');
    }

    /**
     * @return mixed
     */
    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'box_status', 'box_id', 'status_id')
            ->orderBy('pivot_created_at')
            ->withTimestamps();
    }

    /**
     * returns the most recent box status
     *
     * @return mixed
     */
    public function getLatestStatus()
    {
        return $this->statuses()->orderBy('id', 'desc')->first();
    }

    /**
     * @param $status
     * @return bool
     */
    public function statusIsActive($status)
    {
        return $this->box_status == $status->pivot->status_id;
    }

//    /**
//     * @return mixed
//     */
//    public function workers()
//    {
//        return $this->belongsToMany(Worker::class, 'box_worker', 'box_id', 'worker_id')
//                ->withTimestamps();
//    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'historics')->withTimestamps();
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'historics')->withPivot('players_number', 'is_payed', 'price', 'played_at')->withTimestamps();
    }

    public function scopeLatestStatus($query)
    {
        return $query->statuses()->orderBy('id', 'desc');
    }

}