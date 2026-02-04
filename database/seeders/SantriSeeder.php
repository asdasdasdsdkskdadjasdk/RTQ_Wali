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

        $dataSantri = [
            [
                'nis' => '1234567890',
                'nama_santri' => 'Muhammad Santri',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2015-05-15',
                'jenis_kelamin' => 'L',
                'kelas' => '1A',
                'cabang' => 'Pusat',
                'jenis_kelas' => 'Reguler',
            ],
            [
                'nis' => '0987654321',
                'nama_santri' => 'Aisyah Putri',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2016-01-20',
                'jenis_kelamin' => 'P',
                'kelas' => '1B',
                'cabang' => 'Pusat',
                'jenis_kelas' => 'Reguler',
            ],
            [
                'nis' => '1122334455',
                'nama_santri' => 'Umar Kecil',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2015-12-10',
                'jenis_kelamin' => 'L',
                'kelas' => '2A',
                'cabang' => 'Cabang Sukajadi',
                'jenis_kelas' => 'Intensif',
            ],
        ];

        foreach ($dataSantri as $s) {
            if (!Santri::where('nis', $s['nis'])->exists()) {
                Santri::create([
                    'nis' => $s['nis'],
                    'nama_santri' => $s['nama_santri'],
                    'tempat_lahir' => $s['tempat_lahir'],
                    'tanggal_lahir' => $s['tanggal_lahir'],
                    'jenis_kelamin' => $s['jenis_kelamin'],
                    'GolDar' => 'O',
                    'MK' => '1',
                    'email' => strtolower(str_replace(' ', '', $s['nama_santri'])) . '@example.com',
                    'NoHP_ortu' => '08123456789',
                    'asal_sekolah' => 'SD Islam',
                    'pekerjaan_ortu' => 'Karyawan',
                    'nama_ortu' => 'Orang Tua ' . $s['nama_santri'],
                    'kat_masuk' => 'Baru',
                    'asal' => $s['tempat_lahir'],
                    'kelas' => $s['kelas'],
                    'periode_id' => $periode->id,
                    'jenis_kelas' => $s['jenis_kelas'],
                    'cabang' => $s['cabang'],
                ]);
            }
        }
    }
}
