<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Http\FormRequest;

class loginAuth extends FormRequest
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
            'email' => [
                'required', 'exists:customer', 'max:100', 'email:rfc,dns',
                function ($attribute, $value, $fail) {
                    $status = DB::table('customer')
                        ->select('status')
                        ->where('email', '=', request()->email)
                        ->get();
                    if (count($status)) {
                        if (!$status[0]->status) {
                            $fail('La cuenta no esta activada');
                        }
                    }
                }
            ],
            'pass' => [
                'required', 'min:8', 'max:100', 'alpha_dash',
                function ($attribute, $value, $fail) {
                    $hashedPassword = DB::table('customer')
                        ->select('password')
                        ->where('email', '=', request()->email)
                        ->get();
                    if (count($hashedPassword)) {
                        if (!Hash::check($value, $hashedPassword[0]->password)) {
                            //$fail($attribute . ' is invalid.');
                            $fail('La contraseña no es correcta');
                        }
                    }
                }
            ],
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'correo electronico',
            'pass' => 'contraseña',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Ingrese :attribute',
            'pass.required' => 'Ingrese :attribute',
            'pass.alpha_dash' => 'La :attribute solo puede contener letras, números, guiones y guiones bajos.',
            'email.max'  => 'El :attribute debe contener menos caracteres',
            'email.email'  => 'El :attribute no es valido',
            'email.exists'  => 'El :attribute no esta registrado',
            'pass.max'  => 'La :attribute es demasiado larga',
            'pass.min'  => 'La :attribute debe contener mas de 8 caracteres',
        ];
    }
}
