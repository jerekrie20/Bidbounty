<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
    public function createTransaction($buyerId, $sellerId, $itemId)
    {
        // Fetch the buyer and seller
        $buyer = User::findOrFail($buyerId);
        $seller = User::findOrFail($sellerId);

        // Validate roles and create the transaction
        if ($buyer->hasRole('buyer') && $seller->hasRole('seller')) {
            $transaction = new Transaction();
            $transaction->buyer_id = $buyer->id;
            $transaction->seller_id = $seller->id;
            $transaction->item_id = $itemId;

            // Set additional transaction details here
            // $transaction->amount = ...
            // $transaction->transaction_date = ...

            $transaction->save();
            return $transaction;
        } else {
            throw new \Exception("Invalid buyer or seller role");
        }
    }
}

