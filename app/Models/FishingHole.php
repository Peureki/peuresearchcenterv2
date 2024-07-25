<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishingHole extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'map',
        'bait_id',
        'region',
        'time',
        'fishing_power',
        'sample_size',
    ];

    // *
    // * RELATIONSHIPS
    // * 
    public function fishingEstimate(){
        return $this->hasMany(FishingEstimate::class); 
    }
    public function fishingHoleDropRate(){
        return $this->hasMany(FishingHoleDropRate::class); 
    }

    // *
    // * FOREIGN KEYS
    // * 
    public function bait(){
        return $this->belongsTo(Items::class);
    }
    
}
