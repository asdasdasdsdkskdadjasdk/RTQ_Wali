<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;
use App\Models\Periode;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada periode
        $periode = Periode::first();
        if (!$periode) {
            $periode = Periode::create([
                'tahun_awal' => '2025',
                'tahun_akhir' => '2026',
                'tahun_ajaran' => '2025/2026',
            ]);
        }

        if (!Santri::where('nis', '1234567890')->exists()) {
            Santri::create([
                'nis' => '1234567890',
                'nama_santri' => 'Muhammad Santri',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2015-05-15',
                'jenis_kelamin' => 'L',
                'GolDar' => 'A',
                'MK' => '1',
                'email' => 'santri@example.com',
                'NoHP_ortu' => '081987654321',
                'asal_sekolah' => 'SDIT Al-Hikmah',
                'pekerjaan_ortu' => 'Wiraswasta',
                'nama_ortu' => 'Bapak Santri',
                'kat_masuk' => 'Baru',
                'asal' => 'Bandung',
                'kelas' => '1A',
                'periode_id' => $periode->id,
                'jenis_kelas' => 'Reguler',
                'cabang' => 'Pusat',
            ]);
        }
    }
}
