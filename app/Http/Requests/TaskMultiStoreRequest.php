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
            '*.name' => 'required|string|max:255', // Cada task deve ter um title obrigatório e não vazio
            '*.items' => 'nullable|array', // Items são opcionais, mas devem ser um array se existirem
            '*.items.*.name' => 'required_with:*.items|string|max:255', // Se itens existirem, cada item deve ter um campo name obrigatório
        ];
    }
}
