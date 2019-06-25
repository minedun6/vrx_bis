<?php

namespace App\Models\Activity;


use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{

    public function generateDescription()
    {
        $subject = $this->subject;
        $causer = $this->causer;
        $description = $this->description;

        switch ($this->subject_type) {
            case 'App\Models\Game\Game':
                return "Game \"" . $subject->name . "\"" . " was " . $description . ".";
            case 'App\Models\Location\Location':
                return "Adresse \"" . $subject->name . "\"" . " was " . $description . ".";
            case 'App\Models\Box\Box':
                return "Box \"" . $subject->code . "\"" . " was " . $description . ".";
        }

    }

}