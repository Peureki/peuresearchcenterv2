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
        'map_benchmark_id',
        'copper_fed_salvageable_id',
        'runecrafters_salvageable_id',
        'silver_fed_salvageable_id',
        'mixed_salvageable_id',
        'bag_id',
        'fish_id',
        'item_id',
        'currency_id',
        'drop_rate',
        'exotic',
    ];

    /*  
     * FOREIGN KEYS
     */
    public function mapBenchmark(){
        return $this->belongsTo(MapBenchmark::class);
    }

    public function copperFedSalvageable(){
        return $this->belongsTo(CopperFedSalvageable::class);
    }

    public function runecraftersSalvageable(){
        return $this->belongsTo(RunecraftersSalvageable::class); 
    }

    public function silverFedSalvageable(){
        return $this->belongsTo(SilverFedSalvageable::class); 
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
