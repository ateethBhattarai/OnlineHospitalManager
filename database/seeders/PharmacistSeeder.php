<?php

namespace Database\Seeders;

use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PharmacistSeeder extends Seeder
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
            $seederPharmacistData = new Pharmacist;
            $seederUserData = new User;

            //seeding pharmacist data
            $seederPharmacistData->qualification = "OMBS";
            $seederPharmacistData->created_by = $faker->name;
            $seederPharmacistData->modified_by = $faker->name;
            $seederPharmacistData->user_id = $faker->numberBetween(1, 10);
            $seederPharmacistData->pharmacy_id = $faker->numberBetween(1, 4);

            //seeding user data
            $seederUserData->full_name = $faker->name;
            $seederUserData->phone_number = $faker->phoneNumber;
            $seederUserData->address = $faker->address;
            $seederUserData->email = $faker->email;
            $seederUserData->role = 'pharmacist';
            $seederUserData->created_by = $faker->name;
            $seederUserData->modified_by = $faker->name;
            $seederUserData->dob = $faker->dateTime($max = 'now');
            $seederUserData->password = $faker->password;

            $seederUserData->save();
            $seederUserData->getPharmacist()->save($seederPharmacistData);
        }
    }
}
