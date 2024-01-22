<?php

namespace App\Http\Request\ElectricityAccount;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'kwh_number' => 'required|numeric|digits:12',
            'name' => 'required',
            'address' => 'required',
            'cost' => 'required|numeric',
        ];
    }
}
