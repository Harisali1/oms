<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class StoreJoeyRequest extends FormRequest
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

    public function messages()
    {
        return [
        
            'first_name.required' => 'First name field is required',
            'last_name.required' => 'Last name field is required',
            'email.required' => 'Email field is required',
            'phone.required' => 'Phone number field is required',
            'password.required' => 'Password field is required',

        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|max:24',
            'email' => 'required|email|max:255|unique:joeys,email,NULL,id,deleted_at,NULL',
            'password' => 'min:8|required|max:30',
        ];
    }
}
