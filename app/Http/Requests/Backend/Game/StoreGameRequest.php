<?php

namespace App\Http\Requests\Backend\Game;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('manage-games');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // ignore any
            'code' => 'required|unique:games,code,NULL,code,deleted_at,NULL|alpha_num|size:6',
            'name' => 'required',
            'bought_at' => 'date',
            'duration' => 'date_format:H:i:s'
        ];
    }
}
