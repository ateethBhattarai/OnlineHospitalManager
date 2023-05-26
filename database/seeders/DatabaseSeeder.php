<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\InventoryItems;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // UserSeeder::class,
            PatientSeeder::class,
            PharmacySeeder::class,
            DoctorSeeder::class,
            PharmacistSeeder::class,
            AdminSeeder::class,
            AppointmentSeeder::class,
            InventoryItemSeeder::class
        ]);
    }
}
