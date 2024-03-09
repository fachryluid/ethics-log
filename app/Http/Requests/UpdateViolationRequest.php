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
            'department' => 'required',
            'type' => 'required',
            'regulation_section' => 'required',
            'regulation_letter' => 'required',
            'regulation_number' => 'required',
            'regulation_year' => 'required',
            'regulation_about' => 'required',
            'date' => 'required|date',
            'place' => 'required',
            'desc' => 'required|string',
            'evidence' => 'nullable|file|mimes:jpeg,png,gif,mp4,avi,mov,zip,rar|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required' => 'NIP Wajib diisi.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'nip.unique' => 'NIP tersebut sudah terdaftar.',
            'date.required' => 'Tanggal wajib diisi.',
            'place.required' => 'Tempat wajib diisi.',
            'regulation_section.required' => 'Pasal wajib diisi.',
            'regulation_letter.required' => 'Huruf wajib diisi.',
            'regulation_number.required' => 'Nomor wajib diisi.',
            'regulation_year.required' => 'Tahun wajib diisi.',
            'regulation_about.required' => 'Tentang wajib diisi.',
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
