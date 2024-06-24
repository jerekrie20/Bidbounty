<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AuctionCategory extends Model
{
    use HasFactory;

    //Mass assignable attributes
    protected $fillable = [
        'name',
        'description',
        'icon'
    ];

    //Start of the relationship

    // AuctionCategory can have many lots
    public function lots(): BelongsToMany
    {
        return $this->belongsToMany(Lot::class, 'category_lot', 'category_id', 'lot_id');
    }
}
