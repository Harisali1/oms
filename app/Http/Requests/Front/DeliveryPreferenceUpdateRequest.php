<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryPreferenceUpdateRequest extends FormRequest
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
            'title' => 'required|regex:/^[\pL\s\-]+$/u|unique:delivery_preferences,title,'.$this->delivery_preference->id
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => "Please provide delivery preference",
            'title.regex'       => 'Delivery preference may only contain letters',
            'title.unique'      => 'This delivery preference has already been taken',
        ];
    }
}
