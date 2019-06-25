<?php

namespace App\Http\Requests\Backend\Worker;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('manage-workers');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|alpha_num|size:6|unique:games,code,NULL,code,deleted_at,NULL',
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone1' => 'numeric',
            'phone2' => 'numeric',
            'phone3' => 'numeric',
            'started_at' => 'date_format:d/m/Y|before:today',
            'password' => 'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Veuillez saisir votre adresse email.',
            'email.unique' => 'Cette adresse email saisie existe déjà.'
        ];
    }


}
