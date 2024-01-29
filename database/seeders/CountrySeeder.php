<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(database_path('data/countries.csv'), 'r');

        // Skip the header row
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            Country::create([
                'name' => $row[0],
                'code' => $row[1]
            ]);
        }

        fclose($file);
    }
}
