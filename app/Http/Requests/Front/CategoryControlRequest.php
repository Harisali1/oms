<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class CategoryControlRequest extends FormRequest
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
            'order_category_id' => 'required',
            'delivery_type_id' => 'required',
            'delivery_preference_id' => 'required',
            'zone_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'order_category_id.required' => 'Please provide order category',
            'delivery_type_id.required' => 'Please provide delivery type',
            'delivery_preference_id.required' => 'Please provide delivery preference',
            'zone_id.required' => 'Please provide zone',
            'start_time.required' => 'Please provide start time',
            'end_time.required' => 'Please provide end time',
        ];
    }
}
