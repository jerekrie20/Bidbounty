<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    use HasFactory;

    //Start of the relationship

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
