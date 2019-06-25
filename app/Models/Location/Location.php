<?php

namespace App\Models\Location;

use App\Models\Location\Traits\Attribute\LocationAttribute;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class Location extends Model
{
    use Searchable,
        LogsActivity,
        LocationAttribute;

    protected $fillable = [
        'name',
        'city'
    ];

    public function searchableAs()
    {
        return 'locations';
    }


}
