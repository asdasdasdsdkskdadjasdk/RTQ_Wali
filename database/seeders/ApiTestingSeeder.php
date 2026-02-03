<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Santri;
use App\Models\DetailHafalan;
use App\Models\DetailKehadiran;
use App\Models\Periode;
use App\Models\Guru;
use App\Models\JadwalMengajar;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class ApiTestingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // ---------------------------------------------------------
        // 1. DATA PRASYARAT (PERIODE, USER GURU & GURU)
        // ---------------------------------------------------------
        
        // A. Buat Periode
        $periode = Periode::firstOrCreate(
            ['tahun_ajaran' => '2024/2025'],
            [
                'tahun_awal' => 2024,
                'tahun_akhir' => 2025
            ]
        );

        // B. Buat User untuk Guru
        $userGuru = User::firstOrCreate(
            ['email' => 'guru@test.com'],
            [
                'name' => 'Ustadz Penguji',
                'password' => Hash::make('password123')
            ]
        );

        // C. Buat Guru 
        $guru = Guru::firstOrCreate(
            ['nama_guru' => 'Ustadz Penguji'], 
            [
                'tempat_lahir' => 'Pekanbaru',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L', 
                'pend_akhir' => 'S1', 
                'gol_dar' => 'O',
                'mk' => '2 Tahun',
                'bagian' => 'Pengajar',
                'cabang' => 'Pusat',
                'alamat' => 'Jl. Dakwah No. 1',
                'no_hp' => '08123456789',
                'email' => 'guru@test.com',
                'status_menikah' => 'Menikah',
                'jlh_hafalan' => 30,
                'user_id' => $userGuru->id 
            ]
        );

        // D. Buat Jadwal Mengajar (Wajib ada untuk relasi Kehadiran & Hafalan)
        $jadwal = JadwalMengajar::firstOrCreate(
            [
                'guru_id' => $guru->id, 
                'kelas' => '1' 
            ],
            [
                'cabang' => 'Pusat',
                'kegiatan' => 'Tahfidz', 
                'periode_id' => $periode->id, 
                'jam_masuk' => '08:00', 
                'jam_keluar' => '10:00'
            ]
        );

        // ---------------------------------------------------------
        // 2. DAFTAR NAMA SANTRI TARGET
        // ---------------------------------------------------------
        $daftarNama = ['Zahran', 'Abdul', 'Latief', 'Agyul', 'Bayu', 'Zaki'];

        $this->command->info("Memulai generate data untuk: " . implode(", ", $daftarNama));

        foreach ($daftarNama as $index => $nama) {
            
            // A. BUAT USER WALI
            $email = strtolower($nama) . '@test.com';
            
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $nama, 
                    'password' => Hash::make('password123')
                ]
            );

            try {
                if(method_exists($user, 'assignRole')){
                    $user->assignRole('wali_santri');
                }
            } catch (\Exception $e) { }

            // B. BUAT PROFIL SANTRI
            $santri = Santri::create([
                'nis' => '2024' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'nama_santri' => $nama,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2015-12-31'),
                'jenis_kelamin' => 'L', 
                'GolDar' => $faker->randomElement(['A', 'B', 'AB', 'O']),
                'MK' => 1,
                'email' => $email,
                'NoHP_ortu' => $faker->phoneNumber,
                'asal_sekolah' => 'SD IT ' . $faker->city,
                'pekerjaan_ortu' => $faker->jobTitle,
                'nama_ortu' => $faker->name($gender = 'male'),
                'kat_masuk' => 'Baru',
                'asal' => $faker->city,
                'kelas' => $faker->randomElement(['1', '2', '3']),
                'jenis_kelas' => 'Ikhwan',
                'cabang' => 'Pusat',
                'periode_id' => $periode->id,
            ]);

            // C. BUAT 20 DATA HAFALAN
            for ($h = 0; $h < 20; $h++) {
                DetailHafalan::create([
                    'santri_id' => $santri->id,
                    'jadwal_mengajar_id' => $jadwal->id,
                    'juz' => $faker->numberBetween(29, 30),
                    'surah' => $faker->randomElement(['An-Naba', 'An-Naziat', 'Abasa', 'At-Takwir', 'Al-Infitar', 'Al-Mutaffifin']),
                    'ayat_awal' => 1 + ($h * 5),
                    'ayat_akhir' => 5 + ($h * 5),
                    'tanggal' => Carbon::now()->subDays(20 - $h),
                    'is_draft' => 0 
                ]);
            }

            // D. BUAT 20 DATA KEHADIRAN (DIPERBAIKI SESUAI MIGRATION)
            for ($k = 0; $k < 20; $k++) {
                $tgl = Carbon::now()->subDays(20 - $k);
                $status = $faker->randomElement(['Hadir', 'Hadir', 'Hadir', 'Hadir', 'Sakit', 'Izin', 'Alpha']);

                DetailKehadiran::create([
                    'namasantri_id' => $santri->id,
                    'jadwal_mengajar_id' => $jadwal->id, // Wajib sesuai migration
                    'tanggal' => $tgl->format('Y-m-d'),   // Wajib sesuai migration
                    'status_kehadiran' => $status,        // Ganti 'status' jadi 'status_kehadiran'
                    'bukti' => null,                      // Opsional
                    // 'keterangan' => ... DIHAPUS karena kolom tidak ada di database
                    'created_at' => $tgl,
                    'updated_at' => $tgl,
                ]);
            }
        }

        $this->command->info("BERHASIL! Data Dummy untuk 6 Santri telah dibuat.");
    }
}