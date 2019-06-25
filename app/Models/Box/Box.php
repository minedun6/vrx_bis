<?php

namespace App\Models\Box;

use App\Models\Box\Traits\Attribute\BoxAttribute;
use App\Models\Box\Traits\Relationship\BoxRelationship;
use App\Models\Location\Location;
use App\Models\Worker\Worker;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class Box extends Model
{
    use Searchable,
        BoxAttribute,
        LogsActivity,
        BoxRelationship;

    protected $fillable = [
        'code',
        'box_status',
        'price1',
        'price2',
        'price3',
        'location_id',
    ];

    public function searchableAs()
    {
        return 'boxes';
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'location' => $this->location->name,
            'price1' => $this->price1,
            'price2' => $this->price2,
            'price3' => $this->price3,
            'box_status' => $this->status->label,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }


}
