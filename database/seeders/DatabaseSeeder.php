<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(ManagerSeeder::class);
        $this->call(PelaporSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(UnitKerjaSeeder::class);
        $this->call(AtasanUnitKerjaSeeder::class);
        $this->call(KomisiKodeEtikSeeder::class);
    }
}
