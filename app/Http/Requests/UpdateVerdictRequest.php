<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVerdictRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'session_date' => 'required',
            'session_decision_report' => 'required|file|mimes:pdf|max:10240',
            'session_official_report' => 'required|file|mimes:pdf|max:10240',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'session_date.required' => 'Tanggal Sidang harus diisi.',
            'session_decision_report.required' => 'Unggah Putusan Majelis Etik.',
            'session_official_report.required' => 'Unggah Berita Acara.',
            'status.required' => 'Putusan Sidang harus diisi.',
        ];
    }
}
