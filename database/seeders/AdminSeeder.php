<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

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

        //seeding user data
        $seederUserData = new User;
        $seederUserData->full_name = 'Admin admin';
        $seederUserData->phone_number = $faker->phoneNumber;
        $seederUserData->address = $faker->address;
        $seederUserData->email = 'admin@admin.com';
        $seederUserData->role = 'admin';
        $seederUserData->created_by = 'System';
        $seederUserData->modified_by = 'System';
        $seederUserData->dob = $faker->dateTime($max = 'now');
        $seederUserData->password = Hash::make(12345678);
        $seederUserData->save();

        //seeding admin data
        $seederAdminData = new Admin;
        $seederAdminData->user_id = $faker->numberBetween(1, 10);
        $seederAdminData->created_by = 'System';
        $seederAdminData->modified_by = 'System';
        $seederUserData->getPatient()->save($seederAdminData);
    }
}
