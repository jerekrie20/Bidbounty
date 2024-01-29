<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(database_path('data/states.csv'), 'r');

        // Skip the header row
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            State::create([
                'name' => $row[0],
                'code' => $row[1]
            ]);
        }

        fclose($file);

    }
}
