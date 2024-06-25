<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'user_id', 'amount'];

    //Start of the relationship

    //Bid belongs to a user
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //Bid belongs to an item
    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
