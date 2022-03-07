<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class rooms_admin_Update extends FormRequest
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
            'title' => 'required|max:50',
            'description' => 'required|max:450',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|dimensions:min_width=300,min_height=100,max_width=1024,max_height=500',
            'photo1' => 'nullable|image|dimensions:min_width=300,min_height=100,max_width=1024,max_height=500',
            'estado' => ['required', function ($attribute, $value, $fail) {
                if ($value!=='1' && $value!=='0') {
                    $fail('Estado invalido');
                }
            }],
            'type' => 'required|exists:rooms_type,id',
            'input' => 'required',
            'input.*' => 'distinct|exists:characteristics,id'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'nombre',
            'description' => 'descripcion',
            'price' => 'precio',
            'photo' => 'imagen',
            'photo1' => 'imagen',
            'estado' => 'estado',
            'type' => 'tipo habitación',
            'input' => 'caracteristicas',
            'input.*' => 'caracteristica',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Ingrese :attribute',
            'description.required' => 'Ingrese :attribute',
            'price.required' => 'Ingrese :attribute',
            'photo.required' => 'Ingrese :attribute',
            'photo1.required' => 'Ingrese segunda :attribute',
            'estado.required' => 'Ingrese :attribute',
            'type.required' => 'Ingrese :attribute',
            'input.required' => 'Ingrese :attribute',
            'type.exists' => 'El :attribute seleccionado no es válido',
            'input.*.exists' => 'La :attribute seleccionada no es válida',
            'input.*.distinct' => 'La :attribute seleccionada es redundante',
            'title.alpha' => 'El :attribute solo puede contener letras.',
            'description.alpha' => 'El :attribute solo puede contener letras.',
            'price.numeric' => 'El :attribute solo puede contener números.',
            'photo.image' => 'La :attribute solo puede ser jpeg, png, bmp, gif, svg, or webp.',
            'photo1.image' => 'La segunda :attribute solo puede ser jpeg, png, bmp, gif, svg, or webp.',
            'title.max' => 'El campo :attribute debe contener menos caracteres',
            'description.max' => 'El campo :attribute debe contener menos caracteres',
            'photo.dimensions' => 'La :attribute debe contener de 100px a 500px de altura y de 300px a 1024px de ancho',
            'photo1.dimensions' => 'La segunda :attribute debe contener de 100px a 500px de altura y de 300px a 1024px de ancho',
        ];
    }
}
