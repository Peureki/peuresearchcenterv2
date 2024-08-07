<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixedSalvageableDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'currency_id',
        'mixed_salvageable_id',
        'drop_rate',
    ];

    //  *
    //  * FOREIGN KEYS
    //  * 
    public function currency(){
        return $this->belongsTo(Currencies::class); 
    }

    public function mixedSalvageable(){
        return $this->belongsTo(MixedSalvageable::class, 'mixed_salvageable_id', 'id'); 
    }
}
