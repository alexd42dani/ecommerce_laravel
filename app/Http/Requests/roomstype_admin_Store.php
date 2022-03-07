<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class roomstype_admin_Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ingrese :attribute',
            'name.max' => 'El campo :attribute debe contener menos caracteres',
        ];
    }
}
