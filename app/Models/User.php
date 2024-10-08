<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'bio',
        'address',
        'city',
        'state_id',
        'country_id',
        'zip',
        'phone',
        'timezone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Start of the relationship
     public function roles() : BelongsToMany
     {
         return $this->belongsToMany(Role::class);
     }

     // User can have many lots
        public function lots() : HasMany
        {
            return $this->hasMany(Lot::class);
        }

    /**
     * Get the items listed by the user.
     */
    public function items() : HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * User can have many watchlists
     */
    public function watchlists() : HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    /**
     * User can have many bids
     */
    public function bids() : HasMany
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Get the transactions where the user is a buyer.
     */
    public function purchases() : HasMany
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    /**
     * Get the transactions where the user is a seller.
     */
    public function sales() : HasMany
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    //reviews given and received
    public function reviewsGiven() : HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived() : HasMany
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    //messages sent and received
    public function sentMessages() : HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages() : HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }



}
