<?php

namespace Database\Seeders;

use App\Models\AuctionCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuctionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $file = fopen(database_path('data/AuctionCategories.csv'), 'r');

        // Skip the header row
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            AuctionCategory::create([
                'name' => $row[0],
            ]);
        }
        fclose($file);
    }
}
