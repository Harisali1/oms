<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
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
            'zone_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'capacity' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'zone_id.required'    => "Please provide zone",
            'start_time.required'       => 'Please provide start time',
            'end_time.required'      => 'Please provide end time',
            'capacity.required'      => 'Please provide capacity',
        ];
    }
}
