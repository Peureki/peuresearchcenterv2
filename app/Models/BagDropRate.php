<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'bag_id',
        'item_id',
        'currency_id',
        'drop_rate',
        'exotic',
    ];

    public function bag(){
        return $this->belongsTo(Bag::class); 
    }

    public function currency(){
        return $this->belongsTo(Currencies::class);
    }

    public function item(){
        return $this->belongsTo(Items::class); 
    }
}
