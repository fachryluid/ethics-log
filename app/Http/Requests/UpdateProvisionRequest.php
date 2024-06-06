<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProvisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'regulation_section' => 'required',
            'regulation_letter' => 'required',
            'regulation_number' => 'nullable',
            'regulation_year' => 'nullable',
            'regulation_about' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'regulation_section.required' => 'Pasal wajib diisi.',
            'regulation_letter.required' => 'Huruf wajib diisi.',
            'regulation_number.required' => 'Nomor wajib diisi.',
            'regulation_year.required' => 'Tahun wajib diisi.',
            'regulation_about.required' => 'Tentang wajib diisi.',
        ];
    }
}
