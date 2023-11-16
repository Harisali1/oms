<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class VehicleInformationRequest extends FormRequest
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
            'vehicleType.required' => 'Vehicle field is required',
            'make.required' => 'Make field is required',
            'color.required' => 'Color field is required',
            'model.required' => 'Model field is required',
            'license_plate.required' => 'License Plate field  is required',

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
            'vehicleType' => 'required',
            'make' => 'required',
            'color' => 'required',
            'model' => 'required',
            'license_plate' => 'required',
        ];
    }
}
