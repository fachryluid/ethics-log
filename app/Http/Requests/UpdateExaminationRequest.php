<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExaminationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'examination_place' => 'required',
            'examination_date' => 'required',
            'examination_time' => 'required',
            'examination_report' => 'nullable|file|mimes:pdf|max:10240',
            'examination_result' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }
}
