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
            PeriodeSeeder::class, // Periode dulu sebelum Santri
            TestUsersSeeder::class,
            GuruSeeder::class, // Guru butuh User (dari TestUsersSeeder atau buat sendiri)
            SantriSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
