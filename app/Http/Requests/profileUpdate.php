<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class profileUpdate extends FormRequest
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
            'name' => 'required|max:50|alpha',
            'lastname' => 'required|max:50|alpha',
            'direccion' => 'nullable|max:100',
            'pass' => 'nullable|confirmed|max:100|min:8|alpha_dash',
            'tel' => 'required|max:100|alpha_dash',
        ];
    }

    public function attributes()
    {
        return [
            'direccion' => 'dirección',
            'name' => 'nombre',
            'lastname' => 'apellido',
            'pass' => 'contraseña',
            'tel' => 'telefono',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ingrese :attribute',
            'lastname.required' => 'Ingrese :attribute',
            'pass.required' => 'Ingrese :attribute',
            'tel.required' => 'Ingrese :attribute',
            'name.alpha' => 'El :attribute solo puede contener letras.',
            'lastname.alpha' => 'El :attribute solo puede contener letras.',
            'pass.alpha_dash' => 'La :attribute solo puede contener letras, números, guiones y guiones bajos.',
            'tel.alpha_dash' => 'El :attribute solo puede contener letras, números, guiones y guiones bajos.',
            'name.max' => 'En campo :attribute debe contener menos caracteres',
            'lastname.max' => 'En campo :attribute debe contener menos caracteres',
            'direccion.max'  => 'La :attribute debe contener menos caracteres',
            'pass.confirmed'  => 'Las contraseñas no coinciden',
            'pass.max'  => 'La :attribute es demasiado larga',
            'pass.min'  => 'La :attribute debe contener mas de 8 caracteres',
            'tel.max'  => 'El :attribute debe contener menos caracteres',
        ];
    }
}
