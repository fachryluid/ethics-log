<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreViolationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'offender' => 'required|string',
            'desc' => 'required|string',
            'type' => 'required'
        ];
    }
}
 