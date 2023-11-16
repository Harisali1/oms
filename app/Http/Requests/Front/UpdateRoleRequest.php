<?php

namespace App\Http\Requests\Front;
use App\Models\Roles;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $request = $this->all();

        return [
            //'name' => 'required|unique:roles,display_name',
            'name' =>[
                'required',
                Rule::unique('roles','display_name')->where(function ($query) {
                    return $query->where('type', Roles::ROLE_TYPE_NAME);
                })
                    ->ignore($request['id'])
            ],

        ];

    }


}
