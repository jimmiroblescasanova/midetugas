<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
            'account_number' => 'required|digits:5',
            'name' => 'required|string',
            'rfc' => [
                'required',
                'string',
                'min:12',
                'max:13',
                Rule::unique('clients')->ignore($this->client->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('clients')->ignore($this->client->id),
            ],
            'country_code' => 'required|string',
            'phone' => 'required|numeric',
        ];
    }
}
