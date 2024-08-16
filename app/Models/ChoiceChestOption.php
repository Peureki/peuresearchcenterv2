<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoiceChestOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'bag_id',
        'currency_id',
        'choice_chest_id',
        'option',
        'quantity',
        'currency_quantity'
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
