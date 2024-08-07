<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunecraftersSalvageable extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'sample_size'
    ];

    /*
     * RELATIONSHIPS
     */
    public function item(){
        return $this->belongsTo(Items::class, 'id', 'id'); 
    }
    /*
     * FOREIGN KEYS
     */
    public function dropRate(){
        return $this->hasMany(RunecraftersSalvageableDropRate::class);
    }
}
