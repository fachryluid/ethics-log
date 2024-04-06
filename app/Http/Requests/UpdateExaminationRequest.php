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
        ];
    }
}
