<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KinerjaGuru;
use App\Models\Kategori;
use App\Models\Guru;
use App\Models\Periode;

class KinerjaGuruSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Guru::first();
        $periode = Periode::first();

        // Seed Kategori (Master Data)
        $kategoriList = ['Kedisiplinan', 'Kerapihan', 'Administrasi'];
        foreach ($kategoriList as $kat) {
            if (!Kategori::where('kategori', $kat)->exists()) {
                Kategori::create(['kategori' => $kat]);
            }
        }

        // Seed Kinerja Guru
        if ($guru && $periode && !KinerjaGuru::exists()) {
            KinerjaGuru::create([
                'nama_guru' => $guru->nama_guru,
                'periode_id' => (string) $periode->id, // Schema minta string
                'jumlahTelat' => 2,
            ]);
        }
    }
}
