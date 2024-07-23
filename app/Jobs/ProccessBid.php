<?php

namespace App\Jobs;

use App\Events\BidPlaced;
use App\Models\Bid;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Livewire\Volt\updated;

class ProccessBid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $bidData;
    public function __construct($bidData)
    {
        $this->bidData = $bidData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $bid = $this->createBid();
            $this->updateItem($bid);
            $this->broadcastBid($bid);
        });
    }

    private function createBid(): Bid
    {
        //Get the newest bid
        $newestBid = Bid::where('item_id', $this->bidData['item_id'])
            ->orderBy('created_at', 'desc')
            ->first();
        if ($newestBid && $this->bidData['amount'] <= $newestBid->amount ) {
            Log::info('Bid amount is less than the current bid');
            exit();
        }
        return Bid::create($this->bidData);
    }

    private function updateItem(Bid $bid): void
    {
        $item = Item::find($this->bidData['item_id']);
        $item->update(['current_bid' => $this->bidData['amount']]);
    }

    private function broadcastBid(Bid $bid): void
    {
        broadcast(new BidPlaced($bid));
    }
}
