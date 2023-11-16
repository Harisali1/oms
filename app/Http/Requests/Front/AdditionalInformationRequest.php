<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class AdditionalInformationRequest extends FormRequest
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
            'institution_no.required' => 'Institution number field is required',
            'branch_no.required' => 'Branch number field is required',
            'account_no.required' => 'Account number field is required',
            'hst_number.required' => 'Hst number field is required',
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
            'institution_no' => 'required',
            'branch_no' => 'required',
            'account_no' => 'required',
            'hst_number' => 'required',
        ];
    }
}
