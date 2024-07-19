<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'fish_id',
        'currency_id',
        'drop_rate'
    ];

    // *
    // * FOREIGN KEYS
    // * 
    public function item(){
        return $this->belongsTo(Items::class, 'id');
    }

    public function fish(){
        return $this->belongsTo(Fish::class, 'id');
    }

    public function currency(){
        return $this->belongsTo(Currencies::class, 'id');
    }
}
