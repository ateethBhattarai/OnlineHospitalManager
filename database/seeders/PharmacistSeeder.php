<?php

namespace Database\Seeders;

use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

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

            // Seeding pharmacist data
            $seederPharmacistData->qualification = $faker->randomElement(['Pharm. D.', 'MPharm.']);
            $seederPharmacistData->created_by = 'System';
            $seederPharmacistData->modified_by = 'System';

            // Seeding user data
            $seederUserData->full_name = $faker->name;
            $seederUserData->phone_number = '98' . $faker->numberBetween(100000000, 999999999);
            $seederUserData->address = $faker->address;
            $seederUserData->email = $faker->email;
            $seederUserData->role = 'pharmacist';
            $seederUserData->created_by = 'System';
            $seederUserData->modified_by = 'System';
            $seederUserData->dob = $faker->dateTime($max = 'now');
            $seederUserData->password = Hash::make(12345678);

            $seederUserData->save();
            $seederUserData->getPharmacist()->save($seederPharmacistData);
        }
    }
}
