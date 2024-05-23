<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Room;
class Feature extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    
 /**
  * The roles that belong to the Feature
  *
  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
  */
 public function rooms(): BelongsToMany
 {
    return $this->belongsToMany(Room::class, 'room_features');
 }   
}
