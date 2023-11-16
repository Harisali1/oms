<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class WorkPreferencesRequest extends FormRequest
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
            'shiftStoreType.required' => 'Work Type field is required',
            'work_time.required' => 'Work Time field is required',
            'preferred_zone.required' => 'Preferred Zone field is required',
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
            'shiftStoreType' => 'required',
            'work_time' => 'required',
            'preferred_zone' => 'required',
        ];
    }
}
