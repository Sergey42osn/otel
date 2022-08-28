<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccommodationUpdateFormRequest extends FormRequest
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
            'title_pyc' => ['required', 'string', 'max:50', 'min:3'],

            // 'stars_num' => 'required|integer',
            'country' => 'required',
            'city' => 'required',
            'street_house' => 'required',
            'zip_code' => 'required',
            'phone' => 'required|string',
            // 'alt_phone' => 'required',
            'sales_channel' => 'required',
            'allow_child' => 'required',
            // 'child_policy_pyc' => 'required',
            // 'other_rule' => 'required',
            'allow_pets' => 'required',
            'description_pyc' => 'required',
            'certify_terms' => 'required',
            'agree_terms' => 'required',

            'contact_person' => 'required',

        ];
    }
}
