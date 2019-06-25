<?php

namespace App\Models\Worker\Traits\Scope;

use App\Models\Box\Box;

trait WorkerScope
{

    public function scopeUnassigned($query)
    {
        return $query->whereNotIn('id', Box::pluck('id'))->get();
    }

}