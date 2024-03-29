<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
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
        // Tambahkan validasi nya
        return [
            'name' => 'required|max:255',
            'picturePath' => 'required|image',
            'ingredients' => 'required',
            'price' => 'required| integer',
            'rate' => 'required|numeric',
            // Karna tidak ingin menambhkan validasi di types
            'types' => ''
        ];
    }
}
