<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 3; $i++) {

            //seeding user data
            $seederUserData = new User;
            $seederUserData->full_name = $faker->name;
            $seederUserData->phone_number = $faker->phoneNumber;
            $seederUserData->address = $faker->address;
            $seederUserData->email = $faker->email;
            $seederUserData->role = 'admin';
            $seederUserData->created_by = $faker->name;
            $seederUserData->modified_by = $faker->name;
            $seederUserData->dob = $faker->dateTime($max = 'now');
            $seederUserData->password = $faker->password;
            $seederUserData->save();

            //seeding doctor data
            $seederAdminData = new Admin;
            $seederAdminData->user_id = $faker->numberBetween(1, 10);
            $seederAdminData->created_by = $faker->name;
            $seederAdminData->modified_by = $faker->name;
            $seederUserData->getPatient()->save($seederAdminData);
        }
    }
}
