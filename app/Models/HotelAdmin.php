<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelAdmin extends Model
{
    protected $table = 'hotel_admin';
    public $timestamps = true;
    protected $fillable = ['hotel_id', 'user_id'];

    /**
     * Get the hotel that owns the HotelAdmin.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the user that owns the HotelAdmin.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

