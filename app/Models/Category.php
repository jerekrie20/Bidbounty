<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    //Start of the relationship
    public function items() : BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }

    public function lots() : BelongsToMany
    {
        return $this->belongsToMany(Lot::class);
    }
}
