<?php

namespace App\Services;

use App\Jobs\ProccessBid;

class BidService
{

    public function placeBid(array $bidData)
    {
        //Dispatch the job
        ProccessBid::dispatch($bidData);
    }
}
