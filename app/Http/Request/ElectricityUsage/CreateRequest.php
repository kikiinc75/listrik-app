<?php

namespace App\Http\Request\ElectricityUsage;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'account' => 'required|numeric',
            'month' => 'required|numeric|gte:1|lte:12',
            'year' => 'required|numeric',
            'meter_from' => 'required|numeric|gte:0|lt:meter_to',
            'meter_to' => 'required|numeric|gt:meter_from',
        ];
    }
}
