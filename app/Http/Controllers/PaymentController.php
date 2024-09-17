<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateTransactionStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function success(Request $request): \Illuminate\Http\RedirectResponse
    {
        $transactionId = $request->query('transactionId');
        $itemId = $request->query('itemId');

        // Dispatch the job to update the transaction status in the database
        UpdateTransactionStatus::dispatch($transactionId,true);

        return redirect()->route('transactions', ['itemId' => $itemId, 'success' => 'true']);
    }

    public function cancel(Request $request): \Illuminate\Http\RedirectResponse
    {
        $transactionId = $request->query('transactionId');
        $itemId = $request->query('itemId');

        // Dispatch the job to update the transaction status in the database
        UpdateTransactionStatus::dispatch($transactionId,false);

        return redirect()->route('transactions', ['itemId' => $itemId, 'success' => 'false']);
    }
}
