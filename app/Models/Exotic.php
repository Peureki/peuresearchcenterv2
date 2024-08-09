<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exotic extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
    ];

    /* 
     * FOREIGN KEYS
     */ 
    public function items(){
        return $this->belongsTo(Items::class, 'id', 'id');
    }
}
