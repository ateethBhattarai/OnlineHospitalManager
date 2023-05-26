<?php

namespace Database\Seeders;

use App\Models\InventoryItems;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $n = 10;
        for ($i = 0; $i < $n; $i++) {
            // Seeding appointment data
            $seederInventoryData = new InventoryItems;
            $seederInventoryData->item_name = $faker->randomElement(['Amoxicillin', 'Neems', 'Metron DF', 'Sancho', 'Sertraline']);
            $seederInventoryData->item_type = $faker->randomElement(['Paracetamol', 'Diclofenac', 'Ibuprofen', 'Aspirin', 'Analgesics']);
            $seederInventoryData->manufactured_date = $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s');
            $seederInventoryData->expiry_date = $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d H:i:s');
            $seederInventoryData->cost = $faker->numberBetween(1, 99);
            $seederInventoryData->created_by = 'System';
            $seederInventoryData->modified_by = 'System';
            $seederInventoryData->save();
        }
    }
}
