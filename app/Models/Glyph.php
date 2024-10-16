<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Glyph extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'name',
        'type',
        'level',
        'sample_size',
    ];

    /*
     * RELATIONSHIPS
     */

    public function dropRate(){
        return $this->hasMany(GlyphDropRate::class); 
    }

    public function item(){
        return $this->hasMany(Items::class);
    }
}
