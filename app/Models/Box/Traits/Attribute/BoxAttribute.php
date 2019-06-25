<?php

namespace App\Models\Box\Traits\Attribute;

use Carbon\Carbon;

trait BoxAttribute {

    /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="' . route('admin.box.show', $this) . '" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.view') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.box.edit', $this) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a> ';
    }

    /**
     * Make the buttons act as a model property
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.box.destroy', $this) . '"
             data-method="delete"
             data-trans-button-cancel="' . trans('buttons.general.cancel') . '"
             data-trans-button-confirm="' . trans('buttons.general.crud.delete') . '"
             data-trans-title="' . trans('strings.backend.general.are_you_sure') . '"
             class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.delete') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return
            $this->getShowButtonAttribute() .
            $this->getEditButtonAttribute() ;
            //$this->getDeleteButtonAttribute();
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getBoughtAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    /**
     * @return string
     */
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

}