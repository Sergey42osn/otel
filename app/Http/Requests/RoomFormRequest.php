<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomFormRequest extends FormRequest
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
            'number' => 'required',
            'price' => 'required',
//            'size' => 'required',
//            'single_bed' => 'required|integer',
//            'sofa_bed' => 'required|integer',
//            'double_bed' => 'required|integer',
//            'wide_bed' => 'required|integer',
//            'futon' => 'required|integer',
//            'extra_beds' => 'required',
            'guest_count' => 'required'

        ];
    }
}
