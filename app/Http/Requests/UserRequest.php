<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;

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
            // rules dari userController API
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:20', 'unique:users'],
            'password' => $this->passwordRules(),
            'address' => ['required', 'string'],
            // in:USER,ADMIN => Field nya hanya bisa di isi oleh tulisan USER dan tulisan AMDIN
            'roles' => ['required', 'string', 'max:255', 'in:USER, ADMIN'],
            'houseNumber' => ['required' , 'string', 'max:255'],
            'phoneNumber' => ['required' , 'string', 'max:255'],
            'city' => ['required' , 'string', 'max:255'],
        ];
    }
}
