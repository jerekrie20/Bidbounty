<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'buyer_id', 'seller_id', 'amount', 'transaction_date', 'status', 'notes'
    ];


    //Start of the relationship

    /**
     * Get the item associated with the transaction.
     */
    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user who is the buyer in this transaction.
     * Ensure through application logic that this user has the 'buyer' role.
     */
    public function buyer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the user who is the seller in this transaction.
     * Ensure through application logic that this user has the 'seller' role.
     */
    public function seller() : BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
