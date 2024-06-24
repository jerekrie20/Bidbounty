<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Jeremiah Kriegel',
//            'email' => 'jeremiah.kriegel@gmail.com',
//            'password' => bcrypt('password'),
//            'image' => 'Jeremiah Kriegel_5188.png',
//            'bio' => 'I am a web developer and designer with a passion for creating beautiful websites.',
//            'address' => '1234 Elm St',
//            'city' => 'Springfield',
//            'state_id' => 1,
//            'zip' => '12345',
//            'country_id' => 236,
//            'phone' => '123-456-7890',
//            'approved' => true
//        ]);

        $this->call([
//            CountrySeeder::class,
//            StateSeeder::class,
//            CategorySeeder::class,
//            LotSeeder::class
            AuctionCategorySeeder::class
        ]);
    }
}
