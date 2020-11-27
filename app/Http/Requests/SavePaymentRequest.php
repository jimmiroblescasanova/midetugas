<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePaymentRequest extends FormRequest
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
            'document_id' => 'required|exists:documents,id',
            'client_id' => 'required|exists:clients,id',
            'date' => 'required',
            'amount' => 'required',
            'advancePaymentCheck' => 'sometimes',
        ];
    }
}
