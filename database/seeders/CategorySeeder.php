<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(database_path('data/categories.csv'), 'r');

        // Skip the header row
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            Category::create([
                'name' => $row[0],
            ]);
        }
        fclose($file);
    }
}
