<?php

namespace App\Models\Worker\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Affectation\Affectation;
use App\Models\Box\Box;
use App\Models\Game\Game;

trait WorkerRelationship
{
    /**
     * @return mixed
     */
    public function box()
    {
        return $this->belongsTo(Box::class, 'default_box');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'historics')->withTimestamps();
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'historics')->withTimestamps();
    }

    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }

    public function getLatestAffectation()
    {
        return $this->affectations()->orderBy('id', 'desc')->first();
    }

    public function generatedMoney()
    {
        return '<span class="counter">' . number_format($this->games()->where("is_payed", 1)->sum("price"), 3, ".", "") . ' </span> ' . config('app.currency');
    }

}
