<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlyphDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'glyph_id',
        'item_id',
        'currency_id',
        'drop_rate',
    ];

    //  *
    //  * FOREIGN KEYS
    //  * 
    public function item(){
        return $this->belongsTo(Items::class);
    }
    public function glyph(){
        return $this->belongsTo(Glyph::class);
    }
    public function currency(){
        return $this->belongsTo(Currencies::class);
    }
}
