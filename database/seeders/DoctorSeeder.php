<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DoctorSeeder extends Seeder
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

            //seeding user data
            $seederUserData = new User;
            $seederUserData->full_name = $faker->name;
            $seederUserData->phone_number = $faker->phoneNumber;
            $seederUserData->address = $faker->address;
            $seederUserData->email = $faker->email;
            $seederUserData->role = 'doctor';
            $seederUserData->created_by = $faker->name;
            $seederUserData->modified_by = $faker->name;
            $seederUserData->dob = $faker->dateTime($max = 'now');
            $seederUserData->password = $faker->password;
            $seederUserData->save();

            //seeding doctor data
            $seederDoctorData = new Doctor;
            $seederDoctorData->speciality = "Physician";
            $seederDoctorData->qualification = "MBBS";
            $seederDoctorData->availability_time = $faker->date;
            $seederDoctorData->fees = $faker->numberBetween(50, 200);
            $seederDoctorData->user_id = $faker->numberBetween(1, 10);
            $seederDoctorData->created_by = $faker->name;
            $seederDoctorData->modified_by = $faker->name;
            $seederUserData->getPatient()->save($seederDoctorData);
        }
    }
}
