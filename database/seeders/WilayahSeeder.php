<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wilayah;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        Wilayah::create([
            'nama_wilayah' => 'Jakarta'
        ]);

        Wilayah::create([
            'nama_wilayah' => 'Tangerang'
        ]);

        Wilayah::create([
            'nama_wilayah' => 'Bekasi'
        ]);

        Wilayah::create([
            'nama_wilayah' => 'Depok'
        ]);
    }
}