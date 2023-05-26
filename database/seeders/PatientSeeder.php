<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $seederPatientData = new Patient;
            $seederUserData = new User;

            // Seeding patient data
            $seederPatientData->chronic_disease = $faker->randomElement(['diabetes', 'acidity', 'high blood pressure', 'low blood pressure']);
            $seederPatientData->blood_group = $faker->randomElement(['O +', 'O -', 'A +', 'A -', 'AB +', 'AB -', 'B +', 'B -']);
            $seederPatientData->created_by = 'System';
            $seederPatientData->modified_by = 'System';

            // Seeding user data
            $seederUserData->full_name = $faker->name;
            $seederUserData->phone_number = '98' . $faker->numberBetween(100000000, 999999999);
            $seederUserData->address = $faker->address;
            $seederUserData->email = $faker->email;
            $seederUserData->created_by = 'System';
            $seederUserData->modified_by = 'System';
            $seederUserData->dob = $faker->dateTime($max = 'now');
            $seederUserData->password = Hash::make(12345678);

            $seederUserData->save();
            $seederUserData->getPatient()->save($seederPatientData);
        }
    }
}
