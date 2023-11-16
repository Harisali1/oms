<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubAdminRequest extends FormRequest
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

            //'profile_picture.image'  => 'Profile image must be an image',
           // 'profile_picture.mimes'  => 'The profile image  must be a file of type: jpeg, png, jpg, gif.',


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
            'name'  => 'required|max:50',
            'email'      => 'required|email',
            'phone'      => 'required|max:24',
            'upload_file' => 'image|mimes:jpeg,png,jpg|max:5120',
            //'confirm_password'      => 'string|min:6|same:password|max:30',
            //'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
