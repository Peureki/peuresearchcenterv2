<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category',
        'sample_size',
    ];

    // *
    // * RELATIONSHIPS
    // * 
    public function bagDropRate(){
        return $this->hasOne(BagDropRate::class); 
    }

    public function containerDropRate(){
        return $this->hasOne(ContainerDropRate::class); 
    }

    // *
    // * FOREIGN KEY
    // * 
    public function item(){
        return $this->belongsTo(Items::class, 'id'); 
    }
}
