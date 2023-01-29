<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInformationRequest extends FormRequest
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
    public function rules($id)
    {
        return [
            'first_name' => ['required', 'string'],
            'middle_name' => ['nullable', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . ($id ? $id . ',id' : 'NULL,NULL') . ',deleted_at,NULL',],
            'phone_number' => ['required'],
            'gender' => ['required', 'numeric'],
            'marital_status' => ['required', 'numeric'],
            'nationality' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['nullable', 'string'],
            'fathers_name' => ['nullable', 'string'],
            'mothers_name' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'number_dependent' => ['required', 'numeric'],
        ];
    }
}
