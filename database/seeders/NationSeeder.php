<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFilePath = base_path('database/seeders/data/countries.json');

        // Check if the JSON file exists.
        if (File::exists($jsonFilePath)) {
            $json = File::get($jsonFilePath);
            $data = json_decode($json, true);

            // Replace 'table_name' with the name of the table.
            DB::table('nationals')->insert($data);
        } else {
            // Handle the case where the JSON file does not exist.
            echo "JSON file does not exist.";
        }

    }
}
