<?php

namespace App\Http\Requests\Backend\Box;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('manage-boxes');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required',
            'location_id' => 'required|exists:locations,id',
            'default_worker' => 'required|exists:workers,id',
            'box_status' => 'required|exists:statuses,id'
        ];
    }
}
