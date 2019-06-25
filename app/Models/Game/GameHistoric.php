<?php

namespace App\Models\Game;

use App\Models\Affectation\Affectation;
use App\Models\Game\Traits\Relationship\GameHistoryRelationship;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class GameHistoric extends Model
{
    use Searchable,
        LogsActivity,
        GameHistoryRelationship;

    protected $table = 'historics';

    protected $dates = [
        'played_at'
    ];

    protected $casts = [
        'bool' => 'is_payed'
    ];

    /**
     * @return mixed
     */
    public function isPayed()
    {
        return $this->is_payed;
    }

}
