<?php

namespace App\Models\Worker;

use App\Models\Box\Box;
use App\Models\Worker\Traits\Attribute\WorkerAttribute;
use App\Models\Worker\Traits\Relationship\WorkerRelationship;
use App\Models\Worker\Traits\Scope\WorkerScope;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class Worker extends Model
{
    use Searchable,
        SoftDeletes,
        WorkerAttribute,
        WorkerScope,
        LogsActivity,
        WorkerRelationship,
        FormAccessible;

    protected $with = ['user'];

    protected $fillable = [
        'code',
        'phone1',
        'phone2',
        'phone3',
        'default_box',
        'started_at'
    ];

    protected $dates = [
        'started_at'
    ];



}
