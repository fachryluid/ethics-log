<?php

namespace Database\Seeders;

use App\Constants\UserGender;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminExists = User::where('username', 'admin')->exists();

        if ($adminExists) {
            return;
        }

        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'gender' => UserGender::MALE,
            'birthday' => '2002-10-08',
            'phone' => '0812-3456-7890',
            'password' => Hash::make('admin'),
            'email_verified_at' => Carbon::now()
        ]);

        Admin::create([
            'user_id' => $user->id
        ]);
    }
}