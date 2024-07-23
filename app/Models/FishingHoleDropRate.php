<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishingHoleDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'fish_id',
        'fishing_hole_id',
        'bag_id',
        'drop_rate'
    ];

    // *
    // * FOREIGN KEYS
    // * 
    public function item(){
        return $this->belongsTo(Items::class);
    }

    public function fish(){
        return $this->belongsTo(Fish::class);
    }

    public function fishingHole(){
        return $this->belongsTo(FishingHole::class);
    }

    public function bag(){
        return $this->belongsTo(Bag::class); 
    }
}
