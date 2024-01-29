<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    public function reviewer() : belongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee() : belongsTo
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }
}
