<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailHafalan;
use App\Models\Santri;
use App\Models\JadwalMengajar;
use Carbon\Carbon;

class HafalanSeeder extends Seeder
{
    public function run(): void
    {
        $santri = Santri::first();
        $jadwal = JadwalMengajar::first();

        if ($santri && $jadwal && !DetailHafalan::exists()) {
            DetailHafalan::create([
                'santri_id' => $santri->id,
                'jadwal_mengajar_id' => $jadwal->id,
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'juz' => '30',
                'surah' => 'An-Naba',
                'ayat_awal' => '1',
                'ayat_akhir' => '10',
                'is_draft' => false,
            ]);
        }
    }
}
