<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EmploymentRequest extends FormRequest
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
            'employment_status' => ['required', 'numeric'],
            'hired_date' => ['required', 'date'],
            'designation_id' => ['required', 'numeric'],
            // 'sss_number' => ['required'],
            // 'hdmf_number' => ['required'],
            // 'phic_number' => ['required'],
            'is_tax_exempted' => ['required', 'boolean'],
            'is_paid_holidays' => ['required', 'boolean'],
        ];
    }
}
