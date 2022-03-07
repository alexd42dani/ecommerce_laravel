<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class image_admin_Store extends FormRequest
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
            'photo' => 'required|image',
        ];
    }

    public function attributes()
    {
        return [
            'photo' => 'imagen',
        ];
    }

    public function messages()
    {
        return [
            'photo.required' => 'Ingrese :attribute',
            'photo.image' => 'La :attribute solo puede ser jpeg, png, bmp, gif, svg, or webp.',
            'photo.dimensions' => 'La :attribute debe contener de 100px a 500px de altura y de 300px a 1024px de ancho',
        ];
    }
}
