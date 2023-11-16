<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJoeyRequest extends FormRequest
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
            'profile_image.image'  => 'Profile image must be an Image.!',
            'profile_image.mimes'  => 'The Profile image must be a file of type: jpeg, png, jpg.',
            'displayNameAs.required' => 'Display field  is required',
            'nickname.required' => 'Nickname field  is required',
            'phoneNumber.required' => 'Phone field  is required',
            'overview.required' => 'About you field  is required',
            'Address.required' => 'Address field  is required',
            'Apt.required' => 'suit/Apt field  is required',
            'code.required' => 'Postal code field  is required',
            'institutionNumber.required' => 'Institution number field  is required',
            'branchNumber.required' => 'Branch number field  is required',
            'accountNumber.required' => 'Account number field  is required',
            'make.required' => 'Make field  is required',
            'model.required' => 'Model field  is required',
            'color.required' => 'Color field  is required',
            'license.required' => 'License field  is required',
            'shiftStoreType.required' => 'Shift store type field  is required',
            'notificationType.required' => 'Notification type field  is required',

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
            'displayNameAs' => 'required',
            'nickname' => 'required',
            'phoneNumber' => 'required',
            'overview' => 'required',
            'Address' => 'required',
            'Apt' => 'required',
            "code" => "required",
            "institutionNumber" => "required",
            "branchNumber" => "required",
            "accountNumber" => "required",
            "vehicleType" => "required",
            "make" => "required",
            "model" => "required|integer",
            "color" => "required",
            "license" => "required",
            "shiftStoreType" => "required",
            'notificationType' => 'required',
            'profile_image'   => 'image|mimes:jpeg,png,jpg',
        ];
    }
}
