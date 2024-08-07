<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopperFedSalvageableDropRate extends Model
{
    use HasFactory;

    protected $table = 'copper_fed_salvageable_drop_rates';

    protected $fillable = [
        'id',
        'item_id',
        'copper_fed_salvageable_id',
        'drop_rate'
    ];

    /*
     * RELATIONSHIPS
     */
    public function item(){
        return $this->belongsTo(Items::class); 
    }
    public function copperFedSalvageable(){
        return $this->belongsTo(CopperFedSalvageable::class); 
    }
}
