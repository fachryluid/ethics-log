<?php

namespace Database\Seeders;

use App\Imports\PegawaiImport;
use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $rows = Excel::toCollection(new PegawaiImport, public_path('files/Data dummy PNS.xlsx'));

        $pegawais = $rows[0];

        foreach ($pegawais as $pegawai) {
            $name = $pegawai[0];
            $nip = preg_replace('/\D/', '', $pegawai[1]); // just numeric, clear all non numeric character
            $gender = $pegawai[2];
            $class = $pegawai[3];
            $position = $pegawai[4];
            $department = $pegawai[5];

            $dataExist = Pegawai::where(['nip' => $nip])->exists();
            if (!$dataExist) {
                Pegawai::create([
                    'name' => $name,
                    'nip' => $nip,
                    'gender' => $gender,
                    'class' => $class,
                    'position' => $position,
                    'department' => $department,
                ]);
            }
        }
    }
}
