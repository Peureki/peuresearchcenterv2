<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixedSalvageable extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'category',
        'sample_size',
    ];
    // *
    // * RELATIONSHIPS
    // * 
    public function mixedSalvageableDropRate(){
        return $this->hasOne(MixedSalvageableDropRate::class); 
    }
    // *
    // * FOREIGN KEY
    // * 
    public function item(){
        return $this->belongsTo(Items::class); 
    }


}
