<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryTypeUpdateRequest extends FormRequest
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
            'title' => 'required|regex:/^[\pL\s\-]+$/u|unique:delivery_types,title,'.$this->delivery_type->id
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => "Please provide delivery type",
            'title.regex'       => 'Delivery type may only contain letters',
            'title.unique'      => 'This delivery type has already been taken',
        ];
    }
}
