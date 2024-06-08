<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salvageable extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'category',
        'sample_size',
    ];

    public function salvageableDropRate(){
        return $this->hasOne(SalvageableDropRate::class); 
    }

    // *
    // * FOREIGN KEY
    // * 
    public function item(){
        return $this->belongsTo(Items::class); 
    }
}
