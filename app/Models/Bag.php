<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'sample_size',
    ];

    // *
    // * RELATIONSHIPS
    // * 
    public function bagDropRate(){
        return $this->hasOne(BagDropRate::class); 
    }

    // *
    // * FOREIGN KEY
    // * 
    public function item(){
        return $this->belongsTo(Items::class, 'id'); 
    }
}
