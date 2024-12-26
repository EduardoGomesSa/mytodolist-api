<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskMultiStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.items' => 'nullable|array',
            '*.items.*.name' => 'required_with:*.items|string|max:255',
        ];
    }
}
