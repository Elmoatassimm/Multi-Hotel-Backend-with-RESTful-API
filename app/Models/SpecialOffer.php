<?php

namespace App\Models;
use App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id',
        'offer_type',
        'description',
        'start_date',
        'end_date',
    ];

    public function hotel() : BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
   
}
