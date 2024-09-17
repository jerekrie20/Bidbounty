<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTransactionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transactionId;
    protected $status;

    /**
     * Create a new job instance.
     */
    public function __construct($transactionId, $status)
    {
        $this->transactionId = $transactionId;
        $this->status = $status;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transaction = Transaction::find($this->transactionId);

        $item = $transaction->item;

        if($this->status){
            $transaction->status = 'Payment completed'; // or whatever status you need
            $transaction->save();

            $item->status = 'Customer Paid'; // or whatever status you need
            $item->save();
        }
        else{
            $transaction->status = 'Payment Canceled'; // or whatever status you need
            $transaction->save();

            $item->status = 'Payment Canceled'; // or whatever status you need
            $item->save();
        }
    }
}
