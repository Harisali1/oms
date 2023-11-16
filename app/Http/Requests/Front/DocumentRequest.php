<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'driversPermit.mimes'  => 'The drivers permit must be a file of type: jpeg,png,jpg,doc,docx,pdf.',
            'driversPermit.max' => "Maximum file size to upload is 5MB (5120 KB). If you are uploading a Image/Document/Pdf, try to reduce its resolution to make it under 5MB",
            'driversLicense.mimes'  => 'The drivers license must be a file of type: jpeg,png,jpg,doc,docx,pdf.',
            'driversLicense.max' => "Maximum file size to upload is 5MB (5120 KB). If you are uploading a Image/Document/Pdf, try to reduce its resolution to make it under 5MB",
            'workStudyPermit.mimes'  => 'The work study permit must be a file of type: jpeg,png,jpg,doc,docx,pdf.',
            'workStudyPermit.max' => "Maximum file size to upload is 5MB (5120 KB). If you are uploading a Image/Document/Pdf, try to reduce its resolution to make it under 5MB",
            'vehilcleInsurance.mimes'  => 'The vehicle insurance must be a file of type: jpeg,png,jpg,doc,docx,pdf.',
            'vehilcleInsurance.max' => "Maximum file size to upload is 5MB (5120 KB). If you are uploading a Image/Document/Pdf, try to reduce its resolution to make it under 5MB",
            'additionalDocument1.mimes'  => 'The additional document 1 must be a file of type: jpeg,png,jpg,doc,docx,pdf.',
            'additionalDocument1.max' => "Maximum file size to upload is 5MB (5120 KB). If you are uploading a Image/Document/Pdf, try to reduce its resolution to make it under 5MB",
            'additionalDocument2.mimes'  => 'The additional document 2 must be a file of type: jpeg,png,jpg,doc,docx,pdf.',
            'additionalDocument2.max' => "Maximum file size to upload is 5MB (5120 KB). If you are uploading a Image/Document/Pdf, try to reduce its resolution to make it under 5MB",
            'additionalDocument3.mimes'  => 'The additional document 3 must be a file of type: jpeg,png,jpg,doc,docx,pdf.',
            'additionalDocument3.max' => "Maximum file size to upload is 5MB (5120 KB). If you are uploading a Image/Document/Pdf, try to reduce its resolution to make it under 5MB",
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
            "driversPermit" => 'mimes:jpeg,png,jpg,doc,docx,pdf|max:5120',
            "driversLicense" => 'mimes:jpeg,png,jpg,doc,docx,pdf|max:5120',
            "workStudyPermit" => 'mimes:jpeg,png,jpg,doc,docx,pdf|max:5120',
            "vehilcleInsurance" => 'mimes:jpeg,png,jpg,doc,docx,pdf|max:5120',
            "additionalDocument1" => 'mimes:jpeg,png,jpg,doc,docx,pdf|max:5120',
            "additionalDocument2" => 'mimes:jpeg,png,jpg,doc,docx,pdf|max:5120',
            "additionalDocument3" => 'mimes:jpeg,png,jpg,doc,docx,pdf|max:5120',
            "sinNumber" => 'required'
        ];
    }
}
