<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kehadiran;
use App\Models\DetailKehadiran;
use App\Models\Guru;
use App\Models\Santri;
use App\Models\Periode;
use App\Models\JadwalMengajar;
use Carbon\Carbon;

class KehadiranSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Guru::first();
        $periode = Periode::first();
        $santri = Santri::first();
        $jadwal = JadwalMengajar::first();
        $tanggal = Carbon::now()->format('Y-m-d');

        // Seed Table Kehadiran (Rekap per pertemuan)
        if ($guru && $periode && !Kehadiran::exists()) {
            Kehadiran::create([
                'nama_guru' => $guru->nama_guru,
                'kelas' => '1A',
                'cabang' => 'Pusat',
                'kegiatan_santri' => 'Hafalan Rutin',
                'hari_tanggal' => $tanggal,
                'waktu' => '08:00:00',
                'periode_id' => $periode->id,
            ]);
        }

        // Seed Table DetailKehadiran (Absensi per siswa)
        if ($santri && $jadwal && !DetailKehadiran::exists()) {
            DetailKehadiran::create([
                'namasantri_id' => $santri->id,
                'jadwal_mengajar_id' => $jadwal->id,
                'tanggal' => $tanggal,
                'status_kehadiran' => 'Hadir',
                'bukti' => 'bukti_hadir.jpg',
            ]);
        }
    }
}
