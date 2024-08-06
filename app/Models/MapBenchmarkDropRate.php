<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class MapBenchmarkDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'salvageable_id',
        'mixed_salvageable_id',
        'bag_id',
        'fish_id',
        'item_id',
        'currency_id',
        'drop_rate',
    ];

    /*  
     * FOREIGN KEYS
     */
    public function salvageable(){
        return $this->belongsTo(Salvageable::class); 
    }
    public function mixedSalvageable(){
        return $this->belongsTo(MixedSalvageable::class); 
    }
    public function bag(){
        return $this->belongsTo(Bag::class);
    }
    public function fish(){
        return $this->belongsTo(Fish::class);
    }
    public function item(){
        return $this->belongsTo(Items::class); 
    }
    public function currency(){
        return $this->belongsTo(Currencies::class); 
    }
    
}
