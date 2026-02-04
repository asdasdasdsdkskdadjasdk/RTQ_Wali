<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PeriodeSeeder::class,
            TestUsersSeeder::class,
            GuruSeeder::class,
            SantriSeeder::class,
            JadwalMengajarSeeder::class,
            KehadiranSeeder::class,
            HafalanSeeder::class,
            KinerjaGuruSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
