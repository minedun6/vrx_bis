<?php

namespace App\Models\Box;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class Status extends Model
{
    use Searchable;

    protected $fillable = ['label'];

    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'box_status', 'box_id', 'status_id')
            ->withTimestamps();
    }

    public function statusDiffSum()
    {
        $sum = collect();
        return $sum->sum();
    }

    public function colors()
    {
        switch ($this->id) {
            case 1:
                return "bg-green";
                break;
            case 2:
                return "bg-yellow-lemon";
                break;
            case 3:
                return "bg-red";
                break;
            default:
                break;
        }
    }

}
