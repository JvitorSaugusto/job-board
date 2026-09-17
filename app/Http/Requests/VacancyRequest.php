<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'company' => ['required', 'string', 'min:2', 'max:255'],
            'type' => [
                'required',
                Rule::in(['Estágio', 'CLT', 'PJ', 'Meio Período']),
            ],
            'requirements' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser um texto.',
            'title.min' => 'O título deve ter pelo menos 3 caracteres.',
            'title.max' => 'O título deve ter no máximo 255 caracteres.',

            'company.required' => 'O nome da empresa é obrigatório.',
            'company.string' => 'O nome da empresa deve ser um texto.',
            'company.min' => 'O nome da empresa deve ter pelo menos 2 caracteres.',
            'company.max' => 'O nome da empresa deve ter no máximo 255 caracteres.',

            'type.required' => 'Selecione o tipo de contrato.',
            'type.in' => 'O tipo de contrato selecionado é inválido.',

            'requirements.required' => 'Informe os requisitos da vaga.',
            'requirements.string' => 'Os requisitos devem ser um texto.',
            'requirements.min' => 'Os requisitos devem ter pelo menos 10 caracteres.',
            'requirements.max' => 'Os requisitos devem ter no máximo 2000 caracteres.',
        ];
    }
}