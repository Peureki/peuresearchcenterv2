<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SilverFedSalvageable extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'sample_size'
    ];

    /*
     * RELATIONSHIPS
     */
    public function dropRate(){
        return $this->hasMany(SilverFedSalvageableDropRate::class);
    }
    /*
     * FOREIGN KEYS
     */
    
    public function item(){
        return $this->belongsTo(Items::class, 'id', 'id'); 
    }
}
