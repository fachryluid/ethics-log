<?php

namespace Database\Seeders;

use App\Constants\Options;
use App\Models\AtasanUnitKerja;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AtasanUnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $units = UnitKerja::all();

        foreach ($units as $unit) {
            $username = Str::slug($unit->name);
            $dataExists = User::where('username', $username)->exists();

            if ($dataExists) {
                return;
            }

            $user = User::create([
                'name' => 'Atasan ' . $unit->name,
                'username' => $username,
                'password' => Hash::make($this->generateRandomPassword()),
                'email_verified_at' => Carbon::now()
            ]);

            AtasanUnitKerja::create([
                'user_id' => $user->id,
                'unit_kerja_id' => $unit->id
            ]);
        }
    }

    private function generateRandomPassword($length = 10): string
    {
        return Str::random($length);
    }
}
