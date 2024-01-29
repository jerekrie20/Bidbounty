<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    //Start of the relationship

    public function reportable() : MorphTo
    {
        return $this->morphTo();
    }

    public function reporter() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
