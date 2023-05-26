<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

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
            // Seeding user data
            $seederUserData = new User;
            $seederUserData->full_name = $faker->name;
            $seederUserData->phone_number = '98' . $faker->numberBetween(100000000, 999999999);
            $seederUserData->address = $faker->address;
            $seederUserData->email = $faker->email;
            $seederUserData->role = 'doctor';
            $seederUserData->created_by = 'System';
            $seederUserData->modified_by = 'System';
            $seederUserData->dob = $faker->dateTime($max = 'now');
            $seederUserData->password = Hash::make(12345678);
            $seederUserData->save();

            // Seeding doctor data
            $seederDoctorData = new Doctor;
            $seederDoctorData->speciality = $faker->randomElement(['Physician', 'Surgeon', 'Psychiatrists', 'Neurologists', 'Radiologists']);
            $seederDoctorData->qualification = $faker->randomElement(['MBBS', 'MS', 'MD', 'BAMS', 'BHMS']);
            $seederDoctorData->fees = $faker->numberBetween(50, 199);
            $seederDoctorData->user_id = $seederUserData->id;
            $seederDoctorData->created_by = 'System';
            $seederDoctorData->modified_by = 'System';
            $seederUserData->getPatient()->save($seederDoctorData);
        }
    }
}
