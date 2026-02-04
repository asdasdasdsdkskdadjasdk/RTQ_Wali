<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalMengajar;
use App\Models\Guru;
use App\Models\Periode;

class JadwalMengajarSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Guru::first();
        $periode = Periode::first();

        if ($guru && $periode) {
            $dataJadwal = [
                [
                    'guru_id' => $guru->id,
                    'kelas' => '1A',
                    'cabang' => 'Pusat',
                    'kegiatan' => 'Mengajar Al-Quran',
                    'periode_id' => $periode->id,
                    'jam_masuk' => '07:00:00',
                    'jam_keluar' => '12:00:00',
                ],
                [
                    'guru_id' => $guru->id,
                    'kelas' => '1B',
                    'cabang' => 'Pusat',
                    'kegiatan' => 'Murojaah',
                    'periode_id' => $periode->id,
                    'jam_masuk' => '13:00:00',
                    'jam_keluar' => '15:00:00',
                ],
                [
                    'guru_id' => $guru->id,
                    'kelas' => '2A',
                    'cabang' => 'Cabang Sukajadi',
                    'kegiatan' => 'Tahsin',
                    'periode_id' => $periode->id,
                    'jam_masuk' => '16:00:00',
                    'jam_keluar' => '17:30:00',
                ],
            ];

            foreach ($dataJadwal as $jadwal) {
                 // Cek agar tidak duplikat
                if (!JadwalMengajar::where('kelas', $jadwal['kelas'])
                        ->where('kegiatan', $jadwal['kegiatan'])
                        ->exists()) {
                    JadwalMengajar::create($jadwal);
                }
            }
        }
    }
}
