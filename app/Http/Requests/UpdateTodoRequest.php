<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes','string','min:1','max:255'],
            'is_done' => ['sometimes','boolean'],
            'priority' => ['sometimes','integer','between:1,5'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'is_done.boolean' => 'The is_done field must be true or false.',
            'priority.integer' => 'The priority must be an integer.',
            'priority.between' => 'The priority must be between :min and :max.',
        ];
    }
}
