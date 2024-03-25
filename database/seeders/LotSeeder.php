<?php

namespace Database\Seeders;

use App\Models\Lot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(database_path('data/lots.csv'), 'r');

        // Skip the header row
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            Lot::create([
                'user_id' => $row[0],
                'title' => $row[1],
                'description' => $row[2],
                'image' => '',
                'status' => $row[3],
                'start_date' => $row[4],
                'end_date' => $row[5]

            ]);

        }

        fclose($file);
    }
}
