<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchNotes extends Model
{
    use HasFactory;

    protected $table = 'research_note';

    protected $fillable = [
        'item_id',
        'recipe_id',
        'name',
        'disciplines',
        'min_rating',
        'avg_output',
        'ingredients',
        'crafting_value',
        'buy_price',
        'sell_price',
    ];

    protected $casts = [
        'disciplines' => 'array',
        'ingredients' => 'array',
    ];

    // *
    // * RELATIONSHIPS
    // *
    public function items(){
        return $this->belongsTo(Items::class, 'item_id', 'id');
    }

    public function recipes(){
        return $this->belongsTo(Recipes::class, 'recipe_id', 'id');
    }
}
