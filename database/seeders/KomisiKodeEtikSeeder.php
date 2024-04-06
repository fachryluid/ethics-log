<?php

namespace Database\Seeders;

use App\Constants\UserGender;
use App\Models\KomisiKodeEtik;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KomisiKodeEtikSeeder extends Seeder
{
    public function run(): void
    {
        $adminExists = User::where('username', 'komisi')->exists();

        if ($adminExists) {
            return;
        }

        $user = User::create([
            'name' => 'Komisi Kode Etik',
            'username' => 'komisi',
            'email' => 'komisi@gmail.com',
            'gender' => UserGender::MALE,
            'birthday' => '2002-10-10',
            'phone' => '0812-3456-7899',
            'password' => Hash::make('komisi'),
            'email_verified_at' => Carbon::now()
        ]);

        KomisiKodeEtik::create([
            'user_id' => $user->id
        ]);
    }
}
