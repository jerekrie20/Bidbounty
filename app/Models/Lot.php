<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lot extends Model
{
    use HasFactory;

    //Start of the relationship
    public function items() : HasMany
    {
        return $this->hasMany(Item::class, 'lot_id');
    }

    public function categories() : belongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
