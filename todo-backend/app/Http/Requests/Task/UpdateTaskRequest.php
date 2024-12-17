<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'description' => 'sometimes|required|string|max:255',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'sometimes|required|in:high,medium,low',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'is_completed' => 'boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'description.required' => 'Task description is required.',
            'description.max' => 'Task description cannot exceed 255 characters.',
            'due_date.after_or_equal' => 'Due date must be today or a future date.',
            'priority.in' => 'Priority must be high, medium, or low.',
            'category_ids.*.exists' => 'One or more selected categories do not exist.'
        ];
    }
}