<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumable extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'sample_size',
    ];

    /*
        *
        * RELATIONSHIPS
        *
    */
    public function dropRate(){
        return $this->hasMany(ConsumableDropRate::class); 
    }

    /*
        *
        * FOREIGN KEYS
        *
    */
    public function item(){
        return $this->belongsTo(Items::class, 'id'); 
    }

}
