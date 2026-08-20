<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Lot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Seed a handful of items into every lot so the auction / single-item
     * pages and the bidding flow are reviewable. Lots that are "live" get an
     * item whose bidding window is open right now.
     */
    public function run(): void
    {
        $sellerId = User::value('id') ?? 1;
        $categoryIds = Category::pluck('id')->all();

        $titles = [
            'Angus Heifer', 'Utility Tractor', 'Round Hay Bales', 'Laying Hens (Dozen)',
            'Seed Potato Lot', 'Livestock Trailer', 'Galvanized Water Trough', 'Boar Goat',
            'Fruit Tree Saplings', 'Post Hole Digger', 'Bee Hive Starter', 'Dairy Cow',
        ];

        foreach (Lot::all() as $lot) {
            $isLive = $lot->status === 'live';

            for ($i = 0; $i < 3; $i++) {
                $starting = rand(50, 500);

                // Live lot: open a bidding window around "now" so bids can be tested.
                // Other lots: window tied to the lot's own dates when available.
                if ($isLive) {
                    $start = Carbon::now()->subDay();
                    $end = Carbon::now()->addDays(7);
                } else {
                    $start = $lot->start_date ? Carbon::parse($lot->start_date) : Carbon::now()->addDay();
                    $end = $lot->end_date ? Carbon::parse($lot->end_date) : Carbon::now()->addDays(14);
                }

                $item = Item::create([
                    'lot_id' => $lot->id,
                    'user_id' => $sellerId,
                    'title' => $titles[array_rand($titles)] . ' #' . ($i + 1),
                    'description' => 'Sample auction item seeded for testing and review.',
                    'starting_bid' => $starting,
                    'current_bid' => $starting,
                    'reserve_price' => $starting + rand(100, 400),
                    'start_time' => $start,
                    'end_time' => $end,
                    'status' => 'Available',
                ]);

                // Attach 1-2 categories so the item-page category filter works.
                if (! empty($categoryIds)) {
                    $pick = (array) array_rand(array_flip($categoryIds), min(2, count($categoryIds)));
                    $item->categories()->attach($pick);
                }
            }
        }
    }
}
