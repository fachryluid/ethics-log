<?php

namespace Database\Seeders;

use App\Constants\UserGender;
use App\Models\Manager;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        $dataExists = User::where('username', 'pimpinan')->exists();

        if ($dataExists) {
            return;
        }

        $user = User::create([
            'name' => 'Pimpinan',
            'username' => 'pimpinan',
            'email' => 'pimpinan@gmail.com',
            'gender' => UserGender::MALE,
            'birthday' => '2002-10-08',
            'phone' => '0812-3456-7891',
            'password' => Hash::make('pimpinan'),
            'email_verified_at' => Carbon::now()
        ]);

        Manager::create([
            'user_id' => $user->id
        ]);
    }
}
