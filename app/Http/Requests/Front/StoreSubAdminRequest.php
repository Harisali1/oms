<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubAdminRequest extends FormRequest
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

            'name'              => 'required|max:50',
            'email'             => 'required|email|unique:admin_users,email,NULL,id,deleted_at,NULL',
            'phone'             => 'required',
            'password'          => 'min:8|required|max:30',
            'confirm_password'  => 'string|min:8|same:password|max:30',
            'profile_picture'   => 'mimes:jpeg,png,jpg|max:5120',
            'role_id'              => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Please enter the correct phone-number',
            'role_id.required' => ' phone-number',
        ];
    }



}
