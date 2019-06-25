<?php

namespace App\Models\Game\Traits\Relationship;

use App\Models\Box\Box;
use App\Models\Worker\Worker;

trait GameRelationship
{
    /**
     * @return mixed
     */
    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'historics')->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'historics')->withTimestamps();
    }

}