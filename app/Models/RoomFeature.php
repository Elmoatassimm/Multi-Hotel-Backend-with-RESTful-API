<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Room;
class RoomFeature extends Model
{
    use HasFactory;
    protected $table = 'room_features';
    protected $fillable = [
        'room_id',
        'feature_id',
    ];

    public $timestamps = false;
}
