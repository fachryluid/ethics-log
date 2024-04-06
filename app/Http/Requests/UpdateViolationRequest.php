<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateViolationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nip' => 'required|numeric|unique:violations,nip',
            'offender' => 'required|string',
            'class' => 'required',
            'position' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required' => 'NIP Wajib diisi.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'nip.unique' => 'NIP tersebut sudah terdaftar.',
            'offender.required' => 'Nama terlapor wajib diisi.',
            'offender.string' => 'Nama terlapor harus berupa teks.',
            'class.required' => 'Pangkat / golongan terlapor wajib dipilih.', // Only for admin
            'position.required' => 'Jabatan terlapor wajib diisi.', // Only for admin
        ];
    }
}
