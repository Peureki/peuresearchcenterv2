<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishingEstimate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'fishing_hole_id',
        'map',
        'average_fishing_holes',
        'average_time',
        'time_variable',
        'estimate_variable',
    ];

    // *
    // * FOREIGN KEYS
    // * 
    public function fishingHole(){
        return $this->belongsTo(FishingHole::class); 
    }
}
