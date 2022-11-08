<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveClientRequest extends FormRequest
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
            'name' => 'required|string',
            'rfc' => 'required|string|min:12|max:13',
            'email' => 'required|email',
            'reference' => 'required|string|size:7',
            'country_code' => 'required|string',
            'phone' => 'required|numeric',
            'shortName' => 'string|nullable',
            'measurer_id' => ['nullable', 'exists:measurers,id'],
            'line_1' => 'required|string',
            'line_2' => 'nullable|string',
            'line_3' => 'nullable|string',
            'locality' => 'required|string',
            'city' => 'required|string',
            'state_province' => 'required|string',
            'country' => 'required|string',
            'zipcode' => 'required|numeric',
            'project_id' => ['exists:projects,id'],
            'ref1_name' => 'string',
            'ref1_phone' => 'digits:10',
            'ref2_name' => 'string',
            'ref2_phone' => 'digits:10',
        ];
    }
}
