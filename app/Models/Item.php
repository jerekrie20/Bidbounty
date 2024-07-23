<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id', 'user_id', 'category_id', 'title', 'description', 'starting_bid',
        'current_bid', 'reserve_price', 'start_time', 'end_time', 'image', 'status'
    ];

    //start of the relationship

    /**
     * Get the user (seller) who owns the item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lot that this item belongs to.
     */
    public function lot() : BelongsTo
    {
        return $this->belongsTo(Lot::class, 'lot_id');
    }

    public function bids() : HasMany
    {
        return $this->hasMany(Bid::class, 'item_id');
    }

    /**
     * Get the categories this item belongs to.
     */
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the transactions associated with this item.
     */
    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    //watchlist relationship
    public function watchlists() : HasMany
    {
        return $this->hasMany(WatchList::class);
    }

}
