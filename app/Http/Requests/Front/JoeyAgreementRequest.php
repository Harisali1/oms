<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class JoeyAgreementRequest extends FormRequest
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
            'email.required' => 'Email field is required',
            'insurance_agree_accepted.accepted' => 'Check insurance agree field',


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
            'email' => 'required|email',
            'insurance_agree_accepted' => 'accepted',
        ];
    }
}
