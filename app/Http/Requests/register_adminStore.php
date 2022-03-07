<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class register_adminStore extends FormRequest
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
            'email' => 'required|unique:admins|max:100|email:rfc,dns',
            'pass' => 'required|confirmed|max:100|min:8|alpha_dash',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'correo electronico',
            'name' => 'nombre',
            'lastname' => 'apellido',
            'pass' => 'contraseña',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ingrese :attribute',
            'lastname.required' => 'Ingrese :attribute',
            'email.required' => 'Ingrese :attribute',
            'pass.required' => 'Ingrese :attribute',
            'name.alpha' => 'El :attribute solo puede contener letras.',
            'lastname.alpha' => 'El :attribute solo puede contener letras.',
            'pass.alpha_dash' => 'La :attribute solo puede contener letras, números, guiones y guiones bajos.',
            'name.max' => 'En campo :attribute debe contener menos caracteres',
            'lastname.max' => 'En campo :attribute debe contener menos caracteres',
            'email.unique'  => ':attribute ya registrado',
            'email.max'  => 'El :attribute debe contener menos caracteres',
            'email.email'  => 'El :attribute no es valido',
            'pass.confirmed'  => 'Las contraseñas no coinciden',
            'pass.max'  => 'La :attribute es demasiado larga',
            'pass.min'  => 'La :attribute debe contener mas de 8 caracteres',
        ];
    }
}
