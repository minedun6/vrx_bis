<?php

namespace App\Models\Affectation;

use App\Models\Box\Box;
use App\Models\Worker\Worker;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    protected $table = 'box_worker';

    protected $fillable = [
        'worker_id',
        'box_id'
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

}
