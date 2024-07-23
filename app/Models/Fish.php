<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    protected $table = 'Fishes';

    protected $fillable = [
        'id',
        'map',
        'fishing_hole',
        'bait_id',
        'time',
        'sample_size'
    ];

    // *
    // * RELATIONSHIPS
    // * 
    public function fishDropRate(){
        return $this->hasMany(FishDropRate::class);
    }

    // *
    // * FOREIGN KEYS
    // * 
    public function bait(){
        return $this->belongsTo(Items::class); 
    }
}
