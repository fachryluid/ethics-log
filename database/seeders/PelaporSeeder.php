<?php

namespace Database\Seeders;

use App\Constants\UserGender;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PelaporSeeder extends Seeder
{
    public function run(): void
    {
        $userExists = User::where('username', 'johndoe')->exists();

        if ($userExists) {
            return;
        }

        User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@gmail.com',
            'gender' => UserGender::MALE,
            'birthday' => '2002-10-08',
            'phone' => '0812-3456-7893',
            'password' => Hash::make('john1234'),
            'email_verified_at' => Carbon::now()
        ]);
    }
}