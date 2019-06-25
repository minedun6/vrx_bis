<?php

namespace App\Models\Worker\Traits\Attribute;

use Carbon\Carbon;

trait WorkerAttribute
{

    /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="' . route('admin.worker.show', $this) . '" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.view') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.worker.edit', $this) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return
            $this->getShowButtonAttribute() .
            $this->getEditButtonAttribute() ;
    }

    /**
     * @param $date
     */
    public function setStartedAtAttribute($date)
    {
        //$this->attributes['started_at'] = Carbon::parse($date);
    }

    /**
     * @return mixed
     */
    public function getStartedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    /**
     * @return mixed
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    /**
     * @return mixed
     */
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

}

