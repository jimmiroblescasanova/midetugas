<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeasurerRequest extends FormRequest
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
            'brand' => 'required|string',
            'model' => 'required|string',
            'serial_number' => 'required|string|unique:measurers',
            'actual_measure' => 'required|numeric',
            'factor_id' => 'required|numeric',
        ];
    }
}
