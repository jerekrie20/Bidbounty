<?php

namespace App\Jobs;

use App\Events\InsertTransactionData;
use App\Models\Bid;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class InsertTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $this->insertTransaction();
            $this->broadcastTransaction();
        });
    }

    private function insertTransaction(): void
    {
        $data = $this->fillDataArray();
        Transaction::create($data);
    }

    private function fillDataArray(): array
    {
        //Get max bid data
        $maxBid = Bid::where('item_id', $this->item->id)
            ->orderBy('amount', 'desc')
            ->first();
        $data = [
            'item_id' => $this->item->id,
            'buyer_id' => $maxBid->user_id,
            'seller_id' => $this->item->user_id,
            'amount' => $maxBid->amount,
        ];

        return $data;
    }

    private function broadcastTransaction(): void
    {
        broadcast(new InsertTransactionData($this->item));
    }
}
