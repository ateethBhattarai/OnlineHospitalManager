<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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

            //seeding patient data
            $seederPatientData->chronic_disease = $faker->name;
            $seederPatientData->blood_group = "O +";
            $seederPatientData->created_by = $faker->name;
            $seederPatientData->modified_by = $faker->name;
            $seederPatientData->user_id = $faker->numberBetween(1, 10);

            //seeding user data
            $seederUserData->full_name = $faker->name;
            $seederUserData->phone_number = $faker->phoneNumber;
            $seederUserData->address = $faker->address;
            $seederUserData->email = $faker->email;
            $seederUserData->created_by = $faker->name;
            $seederUserData->modified_by = $faker->name;
            $seederUserData->dob = $faker->dateTime($max = 'now');
            $seederUserData->password = $faker->password;

            $seederUserData->save();
            $seederUserData->getPatient()->save($seederPatientData);
        }
    }
}
