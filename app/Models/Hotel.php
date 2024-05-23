<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Room;
use App\Models\Event;
use App\Models\SpecialOffer;
use App\Models\Review;


class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'photos_path',
        'address',
        'phone_number',
        'email',
        'about',
        'rating',
    ];
    
    /**
     * Get all of the comments for the Hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get all of the events for the Hotel
     *
     * 
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get all of the comments for the Hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specialOffers(): HasMany
    {
        return $this->hasMany(SpecialOffer::class);
    }

    /**
     * Get all of the comments for the Hotel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    
}
