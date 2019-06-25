<?php

namespace App\Models\Location\Traits\Attribute;

use Carbon\Carbon;

trait LocationAttribute
{

    /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="' . route('admin.location.show', $this) . '" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.view') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.location.edit', $this) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a>';
    }

    /**
     * Make the buttons act as a model property
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.location.destroy', $this) . '"
             data-method="delete"
             data-trans-button-cancel="' . trans('buttons.general.cancel') . '"
             data-trans-button-confirm="' . trans('buttons.general.crud.delete') . '"
             data-trans-title="' . trans('strings.backend.general.are_you_sure') . '"
             class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.delete') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute()
    {
        return '<a href="' . route('admin.location.restore', $this) . '" name="restore_game" class="btn btn-xs btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.backend.games.restore_game') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute()
    {
        return '<a href="' . route('admin.location.delete-permanently', $this) . '" name="delete_game_perm" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.backend.games.delete_permanently') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        /*if ($this->trashed()) {
            return $this->getRestoreButtonAttribute() .
            $this->getDeletePermanentlyButtonAttribute();
        }
        */

        return
            $this->getShowButtonAttribute() .
            $this->getEditButtonAttribute();
            //$this->getDeleteButtonAttribute();
    }

}

