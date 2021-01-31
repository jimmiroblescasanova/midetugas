<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveAddressRequest extends FormRequest
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
            'client_id' => 'exists:clients,id',
            'line_1' => 'required|string',
            'line_2' => 'nullable|string',
            'line_3' => 'nullable|string',
            'locality' => 'required|string',
            'city' => 'required|string',
            'state_province' => 'required|string',
            'country' => 'required|string',
            'zipcode' => 'required|numeric',
            'project_id' => 'exists:projects,id',
        ];
    }
}
