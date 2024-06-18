<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'bag_id',
        'currency_id',
        'item_id',
        'drop_rate'
    ];

    // *
    // * FOREIGN KEYS
    // * 
    public function currency(){
        return $this->belongsTo(Currencies::class, 'id'); 
    }

    public function bag(){
        return $this->belongsTo(Bag::class, 'id');
    }

    public function item(){
        return $this->belongsTo(Items::class, 'id');
    }
}
