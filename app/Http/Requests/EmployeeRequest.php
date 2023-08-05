<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name' => 'required|min:5|max:50',
            'nrc' => 'required|min:5',
            'phone' => 'required|numeric',
            'email' => 'required|email|min:5',
            'gender' => 'required',
            'address' => 'required|min:5',
            'languages' => 'required',
            'programming_languages' => 'required',
            'career_part' => 'required',
            'level' => 'required',
            'date_of_birth' => "date|before_or_equal:today",
            'image' => 'mimes:jpeg,png,jpg,gif|max:1024'
        ];
    }

    public function messages() 
    {
        return ['name.required' => 'Name require',
                'name.min' => 'Name require minimum 5 characters.',
                'name.max' => 'Name require maximum 50 characters.',
                'nrc.required' => 'NRC require',
                'nrc.min' => 'NRC require minimum 5 characters.',
                'phone.required' => 'Phone require',
                'phone.number_format' => 'Phone must be number only.',
                'email.required' => 'Email require',
                'email.email' => 'Must be email format',
                'email.min' => 'Email require minimum 5.',
                'address.required' => 'Address require',
                'address.min' => 'Address require minimum 5 characters',
                'languages.required' => "Language require",
                'programming_languages.required' => "Programming Language require",
                'career_part.required' => "Career Part require",
                'level.required' => "Level require",
                'date_of_birth.date' => 'Must be type of date',
                'date_of_birth.before_or_equal' => "Date must before today including today",
                'image.mimes' => 'Require image file type',
                'image.max' => 'Maximum 1MB',
        ];
    }
}
