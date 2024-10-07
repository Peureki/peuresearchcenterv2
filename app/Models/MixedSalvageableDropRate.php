<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixedSalvageableDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'currency_id',
        'mixed_salvageable_id',
        'drop_rate',
        'exotic',
    ];

    //  *
    //  * FOREIGN KEYS
    //  * 
    public function item(){
        return $this->belongsTo(Items::class);
    }

    public function currency(){
        return $this->belongsTo(Currencies::class); 
    }

    public function mixedSalvageable(){
        return $this->belongsTo(MixedSalvageable::class, 'mixed_salvageable_id', 'id'); 
    }
}
