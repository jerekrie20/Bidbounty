<?php

namespace App\Jobs;

use App\Models\Lot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateLotStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lot_id;

    public function __construct(Lot $lot)
    {
        $this->lot_id = $lot->id;
    }

    public function handle()
    {
        // retrieve the model
        $lot = Lot::find($this->lot_id);
        // double-check if lot exists in DB
        if($lot) {
            $lot->update(['status' => 'live']);
        }
    }
}
