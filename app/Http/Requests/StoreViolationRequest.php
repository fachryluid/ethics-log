<?php

namespace App\Http\Requests;

use App\Constants\UserRole;
use App\Utils\AuthUtils;
use Illuminate\Foundation\Http\FormRequest;

class StoreViolationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $role = AuthUtils::getRole(auth()->user());

        return [
            'nip' => $role === UserRole::ADMIN ? 'required|numeric|unique:violations,nip' : 'nullable',
            'date' => 'required|date',
            'offender' => 'required|string',
            'desc' => 'required|string',
            'type' => 'required',
            'class' => $role === UserRole::ADMIN ? 'required' : 'nullable',
            'position' => $role === UserRole::ADMIN ? 'required' : 'nullable',
            'department' => 'required',
            'evidence' => 'required|file|mimes:jpeg,png,gif,mp4,avi,mov,zip,rar|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required' => 'NIP Wajib diisi.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'nip.unique' => 'NIP tersebut sudah terdaftar.',
            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            'offender.required' => 'Nama terlapor wajib diisi.',
            'offender.string' => 'Nama terlapor harus berupa teks.',
            'desc.required' => 'Deskripsi pelanggaran wajib diisi.',
            'desc.string' => 'Deskripsi pelanggaran harus berupa teks.',
            'type.required' => 'Jenis kode etik wajib dipilih.',
            'class.required' => 'Pangkat / golongan terlapor wajib dipilih.', // Only for admin
            'position.required' => 'Jabatan terlapor wajib diisi.', // Only for admin
            'department.required' => 'Unit kerja wajib dipilih.',
            'evidence.required' => 'Bukti pelanggaran wajib diunggah.',
            'evidence.file' => 'Bukti pelanggaran harus berupa file.',
            'evidence.mimes' => 'Format file bukti pelanggaran tidak valid. Format yang diperbolehkan: jpeg, png, gif, mp4, avi, mov, zip, rar.',
            'evidence.max' => 'Ukuran file bukti pelanggaran tidak boleh melebihi 10 MB.',
        ];
    }
}
