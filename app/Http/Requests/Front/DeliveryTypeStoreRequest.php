<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class DeliveryTypeStoreRequest extends FormRequest
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
            'title' => 'required|regex:/^[a-zA-Z0-9\pL\s\-]+$/u|unique:delivery_types,title'
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => "Please provide delivery type",
            'title.regex'       => 'Delivery type may only contain letters and numbers',
            'title.unique'      => 'This delivery type has already been taken',
        ];
    }

}
