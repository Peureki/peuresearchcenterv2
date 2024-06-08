<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalvageableDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'salvageable_id',
        'drop_rate',
    ];

    // *
    // * FOREIGN KEYS
    // * 

    public function salvageable(){
        return $this->belongsTo(Salvageable::class);
    }

    public function item(){
        return $this->belongsTo(Items::class);
    }
}
