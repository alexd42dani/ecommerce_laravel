<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class users_admin_Update extends FormRequest
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
            'pass' => 'nullable|confirmed|max:100|min:8|alpha_dash',
            'estado' => ['required', function ($attribute, $value, $fail) {
                if ($value!=='1' && $value!=='0') {
                    $fail('Estado invalido');
                }
            }],
            'nivel' => ['required', function ($attribute, $value, $fail) {
                if ($value!=='1' && $value!=='0') {
                    $fail('Nivel invalido');
                }
            }]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'lastname' => 'apellido',
            'pass' => 'contraseña',
            'estado' => 'estado',
            'nivel' => 'nivel',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ingrese :attribute',
            'lastname.required' => 'Ingrese :attribute',
            'pass.required' => 'Ingrese :attribute',
            'estado.required' => 'Ingrese :attribute',
            'nivel.required' => 'Ingrese :attribute',
            'name.alpha' => 'El :attribute solo puede contener letras.',
            'lastname.alpha' => 'El :attribute solo puede contener letras.',
            'pass.alpha_dash' => 'La :attribute solo puede contener letras, números, guiones y guiones bajos.',
            'name.max' => 'En campo :attribute debe contener menos caracteres',
            'lastname.max' => 'En campo :attribute debe contener menos caracteres',
            'pass.confirmed'  => 'Las contraseñas no coinciden',
            'pass.max'  => 'La :attribute es demasiado larga',
            'pass.min'  => 'La :attribute debe contener mas de 8 caracteres',
        ];
    }
}
