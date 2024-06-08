<?php

namespace App\Http\Requests;

use App\Constants\ViolationStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVerdictRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sessionOfficialReportRule = $this->query('status') === ViolationStatus::PROVEN_GUILTY ? 'required' : 'nullable';
        return [
            'session_date' => 'required|date', // Added date validation for session_date
            'session_decision_report' => 'required|file|mimes:pdf|max:10240',
            'session_official_report' => "{$sessionOfficialReportRule}|file|mimes:pdf|max:10240",
            'status' => 'required|string', // Added string validation for status
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
