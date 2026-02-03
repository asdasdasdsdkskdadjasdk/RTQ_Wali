<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan user Guru ada
        $userGuru = User::where('email', 'guru@gmail.com')->first();

        if (!$userGuru) {
            $userGuru = User::create([
                'name' => 'Guru',
                'email' => 'guru@gmail.com',
                'password' => Hash::make('gururtq123'),
            ]);
            // Assign role jika menggunakan Spatie permissions
            // $userGuru->assignRole('Guru'); 
        }

        // Cek apakah data guru sudah ada
        if (!Guru::where('user_id', $userGuru->id)->exists()) {
            Guru::create([
                'nama_guru' => 'Ust. Abdullah',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'pend_akhir' => 'S1 Pendidikan Agama Islam',
                'gol_dar' => 'O',
                'mk' => '1',
                'bagian' => 'Pengajar',
                'cabang' => 'Pusat',
                'alamat' => 'Jl. Kebahagiaan No. 1',
                'no_hp' => '081234567890',
                'email' => 'guru@gmail.com', // Email guru, bisa sama atau beda dengan user
                'status_menikah' => 'Menikah',
                'jlh_hafalan' => 30, //misal 30 juz
                'user_id' => $userGuru->id,
            ]);
        }
    }
}
