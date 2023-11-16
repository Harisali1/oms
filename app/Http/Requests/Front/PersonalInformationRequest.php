<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInformationRequest extends FormRequest
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
            'profile_image.image'  => 'Profile image must be an Image.!',
            'profile_image.mimes'  => 'The Profile image must be a file of type: jpeg, png, jpg.',
            'first_name.required' => 'First name field is required',
            'last_name.required' => 'Last name field is required',
            'phone.required' => 'Phone number field is required',
            'email.required' => 'Email field is required',
            'address.required' => 'Address field  is required',

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
            'profile_image'   => 'image|mimes:jpeg,png,jpg',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
        ];
    }
}
