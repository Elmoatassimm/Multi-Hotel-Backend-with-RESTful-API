<?php

namespace App\Models;
use App\Models\User;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'hotel_id',
        'rating',
        'comment',
        'review_date',
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotel() : BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

}
