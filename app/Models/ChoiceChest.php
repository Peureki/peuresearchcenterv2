<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoiceChest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
    ];

    /*
        *
        *   RELATIONSHIPS
        *
    */
    public function option(){
        return $this->hasMany(ChoiceChestOption::class); 
    }

    /*
        *
        *   FOREIGN KEYS
        *
    */
    public function item(){
        return $this->belongsTo(Items::class); 
    }

    
}
