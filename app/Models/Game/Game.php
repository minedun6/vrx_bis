<?php

namespace App\Models\Game;

use App\Models\Game\Traits\Attribute\GameAttribute;
use App\Models\Game\Traits\Relationship\GameRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class Game extends Model
{
    use Searchable,
        SoftDeletes,
        GameAttribute,
        LogsActivity,
        GameRelationship;

    protected $fillable = [
        'code',
        'name',
        'bought_at',
        'duration',
    ];

    protected $dates = [
        'deleted_at',
        'bought_at'
    ];

    public function searchableAs()
    {
        return 'games';
    }


}
