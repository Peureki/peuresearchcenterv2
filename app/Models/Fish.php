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
        'bait',
        'time',
        'sample_size'
    ];

    // *
    // * RELATIONSHIPS
    // * 
    public function fishDropRate(){
        return $this->hasMany(FishDropRate::class);
    }
}
