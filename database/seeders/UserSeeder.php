<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
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
        }
    }
}
