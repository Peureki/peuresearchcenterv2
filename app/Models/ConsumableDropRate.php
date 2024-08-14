<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'consumable_id',
        'currency_id',
        'item_id',
        'drop_rate'
    ];

    /*
        *
        * FOREIGN KEYS
        *
    */
    public function item(){
        return $this->belongsTo(Items::class);
    }
    public function consumable(){
        return $this->belongsTo(Consumable::class);
    }
}
