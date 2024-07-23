<?php

namespace App\Jobs;

use App\Events\ItemStatusUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateItemStatus implements ShouldQueue
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
        $this->updateItemStatus();
        $this->broadcastItemStatus();
    }

    private function updateItemStatus(): void
    {
        $this->item->update(['status' => 'pending']);
    }

    private function broadcastItemStatus(): void
    {
        broadcast(new ItemStatusUpdated($this->item));
    }
}
