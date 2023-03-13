<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
            'user_id' => ['required','exists:users,id'],
            'project_id' => ['nullable','exists:projects,id'],
            'date' => ['required', 'date'],
            'time_in' => ['required'],
            'time_out' => ['required'],
        ];
    }
}
