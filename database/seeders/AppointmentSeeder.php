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
        for ($i = 0; $i < 10; $i++) {

            //seeding appointment data
            $seederAppointmentData = new Appointment;
            $seederAppointmentData->doctor_id = $faker->numberBetween(1, 10);
            $seederAppointmentData->patient_id = $i + 1;
            $seederAppointmentData->visit_date_and_time = $faker->date;
            $seederAppointmentData->symptoms = $faker->name;
            $seederAppointmentData->created_by = $faker->name;
            $seederAppointmentData->modified_by = $faker->name;
            $seederAppointmentData->save();
        }
    }
}
