<?php

namespace Database\Seeders;

use App\Models\Pharmacy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PharmacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 4; $i++) {
            $seederData = new Pharmacy;
            $seederData->sector = $i + 1;
            $seederData->closing_time = $faker->date;
            $seederData->opening_time = $faker->date;
            $seederData->created_by = $faker->name;
            $seederData->modified_by = $faker->name;
            $seederData->save();
        }
    }
}
