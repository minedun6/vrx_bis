<?php
/**
 * Created by PhpStorm.
 * User: Yassine Ben Slimane
 * Date: 29/12/2016
 * Time: 20:53
 */

namespace App\Models\Box;


use Illuminate\Database\Eloquent\Model;

class BoxStatus extends Model
{
    protected $table = 'box_status';

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

}