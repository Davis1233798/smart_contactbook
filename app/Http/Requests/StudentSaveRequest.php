<?php

namespace App\Http\Requests;

use App\Models\APIs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentSaveRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'student.school_number' => [
                'required',
                Rule::unique('students', 'school_number')->where(function ($query) {
                    return $query->whereNotNull('school_number');
                })
            ],
        ];
    }

    public function messages()
    {
        return [
            'student.school_number.required' => __('學生學號是必需的'),
            'student.school_number.unique' => __('學生學號已存在'),
        ];
    }
}
