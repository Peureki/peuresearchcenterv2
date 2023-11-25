<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'output_item_id',
        'output_item_count',
        'time_to_craft_ms',
        'disciplines',
        'min_rating',
        'flags',
        'ingredients',
        'guild_ingredients',
        'chat_link',
    ];

    protected $casts = [
        'disciplines' => 'array',
        'flags' => 'array',
        'ingredients' => 'array',
        'guild_ingredients' => 'array',
    ];


    // Relationship between Recipes <-> Items dbs
    // Use Recipes->outputItem (match the name) to access the item's id within the Items db 
    public function outputItem(): BelongsTo {
        return $this->belongsTo(Items::class, 'output_item_id');
    }
}
