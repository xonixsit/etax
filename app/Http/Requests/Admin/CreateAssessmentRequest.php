<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAssessmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'duration' => ['required', 'integer', 'min:5', 'max:180'],
            'passing_score' => ['required', 'integer', 'min:0', 'max:100'], 
            'due_date' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please provide an assessment title.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'description.required' => 'Please provide a description of the assessment.',
            'description.max' => 'The description cannot exceed 2000 characters.',
            'duration.required' => 'Please specify the time limit.',
            'duration.min' => 'The time limit must be at least 5 minutes.',
            'duration.max' => 'The time limit cannot exceed 180 minutes.',
            'passing_score.required' => 'Please specify the passing score percentage.',
            'passing_score.min' => 'The passing score cannot be less than 0%.',
            'passing_score.max' => 'The passing score cannot exceed 100%.',
            'month.required' => 'Please select a month.',
            'month.min' => 'Invalid month selected.',
            'month.max' => 'Invalid month selected.',
            'year.required' => 'Please select a year.',
            'due_date.required' => 'Please select a due date.',
            'due_date.date' => 'Invalid date.',
            'year.min' => 'Year must be 2024 or later.',
            'year.max' => 'Year cannot be beyond 2100.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'assessment title',
            'description' => 'assessment description',
            'duration' => 'time limit',
            'passing_score' => 'passing score',
            'month' => 'assessment month',
            'year' => 'assessment year',
        ];
    }
}