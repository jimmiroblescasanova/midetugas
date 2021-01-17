<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
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
            'date' => 'required',
            'contract_number' => 'required',
            'type' => 'required',
            'total' => 'numeric|required',
            'client_id' => 'exists:clients,id|required',
            'tax_address' => 'nullable',
        ];
    }
}
