<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'card' => 'required|numeric|regex:/[0-9]{14,16}/i',
            'cvc' => 'required|numeric|digits_between:3,4',
            'month' => 'required|date_format:"m"',
            'year' => 'required|date_format:"Y"',
        ];
    }
}
