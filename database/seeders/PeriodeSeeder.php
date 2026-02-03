<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan periode dengan ID 1 ada
        if (!Periode::find(1)) {
            Periode::create([
                'id' => 1, // Paksa ID 1 agar cocok dengan payload API
                'tahun_awal' => '2025',
                'tahun_akhir' => '2026',
                'tahun_ajaran' => '2025/2026',
            ]);
        }
    }
}
