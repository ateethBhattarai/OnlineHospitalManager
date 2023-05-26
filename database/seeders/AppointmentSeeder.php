<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $n = 10;
        for ($i = 0; $i < $n; $i++) {
            // Seeding appointment data
            $seederAppointmentData = new Appointment;
            $seederAppointmentData->doctor_id = $faker->numberBetween(1, 10);
            $seederAppointmentData->patient_id = $i + 1;
            $seederAppointmentData->visit_date_and_time = $faker->dateTimeBetween('+1 day', '+1 month')->format('Y-m-d H:i:s');
            $seederAppointmentData->symptoms = $faker->randomElement(['diabetes', 'high blood pressure', 'low blood pressure', 'acidity']);
            $seederAppointmentData->created_by = 'System';
            $seederAppointmentData->modified_by = 'System';
            $seederAppointmentData->save();
        }
    }
}
