<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser um texto.',
            'title.min' => 'O título deve ter pelo menos 3 caracteres.',
            'title.max' => 'O título deve ter no máximo 255 caracteres.',
            'description.string' => 'A descrição deve ser um texto.',
            'description.max' => 'A descrição deve ter no máximo 1000 caracteres.',
        ];
    }
}

