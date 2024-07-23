<?php

namespace Tests\Feature;

use App\Models\Bid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProccessBidTest extends TestCase
{

    /**
     * A test simulating multiple people bidding the same item
     * with different amount at the same time.
     *
     * @return void
     */
    public function test_multiple_people_bidding_different_amount_at_same_time()
    {
        $item_id = 1;
        // Create 3 different users bidding at the same time
        $bids = [
            ['user_id' => 1, 'item_id' => $item_id, 'amount' => 100],
            ['user_id' => 1, 'item_id' => $item_id, 'amount' => 200],
            ['user_id' => 1, 'item_id' => $item_id, 'amount' => 300],
        ];

        foreach($bids as $bidData) {
            dispatch(new \App\Jobs\ProccessBid($bidData));
        }

        // Check database to see which bid is accepted
        $latestBid = Bid::where('item_id', $item_id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Assert that the highest bid was accepted
        $this->assertEquals(300, $latestBid->amount);
    }
}
