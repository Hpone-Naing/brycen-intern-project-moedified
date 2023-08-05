<?php

namespace App\Http\Requests;

use App\Rules\CheckDateRange;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required',
            // 'project_name' => 'required|unique:projects,name',
            'start_date' => [
                'required',
                new CheckDateRange($this->input('employee_id')),
                'date',
                'after_or_equal:today',
            ],
            'end_date' => [
                'required',
                new CheckDateRange($this->input('employee_id')),
                'date',
                'after_or_equal:start_date',
                'after_or_equal:today',

            ],
            'files' => 'required',
            
        ];
    }

    public function messages() 
    {
        return [
            'employee_id.required' => 'Employee Id require',
            'project_name.required' => 'Project Name require',
            'project_name.unique' => 'Project Name must be unique',
            'start_date.required' => 'Start Date require',
            'end_date.required' => 'End Date require',
            'files.required' => 'Documentations Files require'
        ];
    }
}
