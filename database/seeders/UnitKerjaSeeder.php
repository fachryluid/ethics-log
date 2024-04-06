<?php

namespace Database\Seeders;

use App\Constants\Options;
use App\Models\UnitKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $units = Options::UNIT_KERJA;

        foreach ($units as $unit) {
            $dataExists = UnitKerja::where('name', $unit)->exists();

            if ($dataExists) {
                return;
            }

            UnitKerja::create([
                'name' => $unit
            ]);
        }
    }
}
