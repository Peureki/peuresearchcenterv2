<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SilverFedSalvageableDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'silver_fed_salvageable_id',
        'drop_rate'
    ];

    /*
     * RELATIONSHIPS
     */
    public function item(){
        return $this->belongsTo(Items::class); 
    }
    public function runecraftersSalvageable(){
        return $this->belongsTo(SilverFedSalvageable::class); 
    }
}
