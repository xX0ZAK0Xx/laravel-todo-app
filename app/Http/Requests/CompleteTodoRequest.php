<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompleteTodoRequest extends FormRequest
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
            'is_done' => ['required','boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'is_done.required' => 'The is_done field is required.',
            'is_done.boolean' => 'The is_done field must be true or false.',
        ];
    }
}
