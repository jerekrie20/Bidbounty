<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WatchList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
    ];

    //Start of the relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); //A watchlist belongs to a user
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class); //A watchlist belongs to an item
    }
}
